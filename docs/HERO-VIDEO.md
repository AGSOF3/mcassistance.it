# Hero 3D — cella robotizzata

Visualizzazione illustrativa originale creata con Blender 4.3.2. La scena rappresenta una cella di finitura con braccio articolato, stazione di pulitura, rulliera, quadro operatore e protezioni. Non utilizza foto, modelli o texture di terze parti e non viene presentata come ricostruzione di uno specifico impianto M.C. Assistance. La sezione portfolio mantiene le immagini reali.

Il filmato è renderizzato nativamente a **1920×1080**, senza ingrandire un video di risoluzione inferiore. La sorgente 3D produce 49 pose a intervalli regolari su un ciclo di 6 secondi; FFmpeg interpola il movimento da 8 a 24 fps, includendo il raccordo di chiusura del loop. H.264/yuv420p e faststart per compatibilità con browser desktop e mobile. Nessuna traccia audio.

## Rigenerazione

Prerequisiti di authoring: Blender 4.3+, FFmpeg con libx264/minterpolate, Python 3 e Pillow con AVIF/WebP. Questi strumenti non sono necessari per eseguire il sito: i file pronti sono inclusi nel branch.

```sh
mkdir -p /tmp/mc-hero-render /tmp/mc-hero-poster
MESA_SHADER_CACHE_DIR=/tmp/mc-mesa-cache blender -b -t 8 --python tools/render_hero.py -- --end 145 --step 3 --samples 4 --output /tmp/mc-hero-render
MESA_SHADER_CACHE_DIR=/tmp/mc-mesa-cache blender -b -t 8 --python tools/render_hero.py -- --still --samples 16 --output /tmp/mc-hero-poster
python3 tools/encode_hero.py --frames /tmp/mc-hero-render --poster /tmp/mc-hero-poster/preview.png
```

L'encoding richiede la sequenza completa, evitando di distribuire video parziali. Per una sola anteprima rapida si può usare `--still --engine BLENDER_WORKBENCH`; i video distribuiti utilizzano Eevee con illuminazione della scena.

## Integrazione

- `assets/video/robotic-cell-1080.mp4`: Full HD desktop.
- `assets/video/robotic-cell-720.mp4`: variante mobile 1280×720.
- `assets/precision/robotic-cell-*`: poster responsive AVIF/WebP, visibile anche senza JavaScript o se il video non è riproducibile.
- Avvio in loop senza audio dopo il caricamento iniziale; comando pausa/riproduci con etichetta IT/EN.
- `prefers-reduced-motion` o `navigator.connection.saveData`: nessuna richiesta automatica del video, poster statico e avvio solo su richiesta esplicita.
- Pausa quando la hero esce dallo schermo o la scheda del browser è nascosta; la pausa manuale viene mantenuta.
- Il logo usa l'immagine originale `assets/img/logop.png` come fallback e due derivati WebP della stessa immagine per ridurre il download. Nessun cambiamento al file originale.
- Sezione persone rimossa dalla pagina azienda in italiano e inglese; fotografie conservate nel repository.

## Verifiche

```sh
python3 tests/smoke.py
PLAYWRIGHT_MODULE=/opt/codex/cua_node/lib/node_modules/playwright node tests/hero.cjs
```

Il test browser verifica logo originale, rimozione persone, assenza di download in modalità movimento ridotto/risparmio dati, dimensioni effettive dei video, avvio e pausa, sospensione fuori schermo e assenza di overflow mobile. Le misure Lighthouse del redesign originale precedono questa modifica: il report della nuova hero è separato per non confonderle.

Risultati verificati nel cloud:

- Entrambi i file: 144 frame, 24 fps, durata 6,000 s, solo stream video H.264. Full HD 434.314 byte; mobile 171.647 byte.
- Riproduzione e pausa verificate in Chromium, compresi cambio preferenza di movimento, sospensione fuori schermo, risparmio dati e fallback in caso di errore di rete.
- Regressione: 44 URL e 108 risorse locali; filtri portfolio, IT/EN, navigazione, modulo email e layout a 360/390/768/1440 px.
- Lighthouse mobile con nuova hero attiva: Performance 100, Accessibility 100, Best Practices 100, SEO 100; LCP 1,3 s, CLS 0, TBT 20 ms. Risultato di laboratorio, non misura sul dominio pubblico. Dettagli in `hero-validation.json`.
