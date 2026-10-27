# M.C. Assistance — Precision in motion

## Architettura e direzione visiva

Sito PHP 8.2 multipagina, senza framework o dipendenze di produzione aggiuntive. `site/render.php` contiene i componenti condivisi e i template; `site/data.php` contiene testi IT/EN, percorsi, applicazioni e portfolio. Gli entry point nelle cartelle italiane e inglesi selezionano lingua e pagina. CSS e JS nativi in `assets/precision/`.

Palette grafite / bianco caldo / lime, tipografia di sistema senza richieste remote, fotografia industriale originale. Componenti: hero cinematografica statica, griglia tecnica CSS, card interattive delle soluzioni, portfolio filtrabile, processo espandibile con tastiera, dettagli tecnici e indicatori storici. Animazioni limitate a opacity/transform e disattivate con prefers-reduced-motion. La hero riproduce un video 3D illustrativo in loop senza audio, con comando pausa e fallback statico per movimento ridotto e risparmio dati. I video del portfolio non partono automaticamente. Anche le copertine dei video vengono caricate vicino al viewport tramite IntersectionObserver. La risposta HTML usa gzip quando disponibile e accettato dal browser.

## Analisi dei contenuti e preservazione

Il checkout originale comprende una home italiana e una inglese, asset Bootstrap e librerie vendorizzate, due applicazioni gestionali PHP e PHPMailer incluso nel gestionale. Non esisteva un build frontend o una suite di test del sito pubblico. L'accesso al sito remoto ha restituito un rifiuto di rete del proxy (403); l'analisi dei contenuti si basa sui file del repository.

- 15 foto di realizzazioni, tutte presenti nel nuovo portfolio. Inclusa `rubinetteria3.jpeg`, prima non esposta nella griglia.
- Due video MP4 riprodotti a richiesta; il MOV originale resta disponibile con link dedicato. Gli originali non sono stati rimossi o modificati.
- `docs/assets.json` cataloga sorgenti delle immagini utilizzate, dimensioni e peso. Derivati AVIF con fallback WebP a 480/720/960/1600 px dove la risoluzione originale lo permette; nessun ingrandimento artificiale dei formati maggiori.
- Date documentate: fondazione giugno 2000, prima cella completa nel 2016. Il dato 131 è mantenuto con nota storica relativa al ventennale, senza presentarlo come totale attuale. Non vengono inventati volumi produttivi, tempi ciclo o specifiche.
- La sezione delle persone è stata rimossa dalle pagine azienda IT/EN su richiesta. Le fotografie originali restano nel repository. Il marchio nell’header e nel footer utilizza `assets/img/logop.png`, con derivati WebP per alleggerire il download.
- Indirizzo, email, telefono, P. IVA, codice fiscale, link social e documento sugli aiuti pubblici 2023 sono mantenuti. Rimossi i recapiti placeholder del vecchio form nascosto. Favicon con percorso e maiuscole corretti.
- Entrambi i gestionali sono integralmente conservati e non modificati. Il link principale mantiene `/CadTimbratore/area-riservata/`.
- Privacy e trasparenza hanno pagine IT/EN dedicate. L'informativa preesistente è preservata nel contenuto e integrata con il funzionamento effettivo del form e della mappa. Il titolare dovrebbe verificare l'adeguatezza legale complessiva prima del rilascio.
- Canonical, hreflang IT/EN, metadati social, Organization JSON-LD e sitemap con 44 URL. I vecchi link con ancore azienda/contatti/team/trasparenza vengono indirizzati alle nuove pagine; servizi e portfolio rimangono disponibili come sezioni in home.

## Contatti e integrazioni

I vecchi endpoint `forms/contact.php` e `en/forms/contact.php` non esistevano. Il nuovo modulo valida i dati e prepara una mail con destinatario `info@mcassistance.it`. L'utente attiva il link e conferma l'invio nel proprio client email: nessuna conferma fittizia di recapito e nessun dato del modulo archiviato dal sito. Email e telefono sono sempre disponibili. Un invio direttamente dal server richiede un servizio SMTP/API con credenziali e verifica del recapito; non è configurato in questo intervento.

La mappa Google viene caricata soltanto dopo un click esplicito e non richiede una chiave esposta. Non sono caricati analytics, font remoti o video di terze parti. Le integrazioni e gli script delle aree gestionali restano invariati.

## Avvio e verifiche

Nel cloud l'immagine Docker `mcassistance-dev:php82` include PHP 8.2 e mysqli/pdo_mysql. Il checkout è montato in sola lettura nel container, mentre le modifiche sul filesystem host sono immediatamente visibili.

```sh
sh /workspace/setup-mcassistance/start.sh
python3 tests/smoke.py
PLAYWRIGHT_MODULE=/opt/codex/cua_node/lib/node_modules/playwright node tests/browser.cjs
PLAYWRIGHT_MODULE=/opt/codex/cua_node/lib/node_modules/playwright AXE_MODULE=/tmp/mc-tools/node_modules/@axe-core/playwright node tests/accessibility.cjs
```

Al di fuori del cloud, usare PHP 8.2 (`php -S 127.0.0.1:8080 -t .`), Python 3 e Playwright con Chromium per i test browser. `CHROME_PATH` permette di cambiare il percorso dell'eseguibile Chromium, `PLAYWRIGHT_MODULE` il modulo Playwright installato. I test browser scrivono screenshot e risultati in `/tmp/mc-results`. Le dipendenze di verifica non fanno parte del sito distribuito. Il test accessibilità richiede anche `@axe-core/playwright` (configurabile tramite `AXE_MODULE`). Nessun comando di build applicativo è necessario.

Validazioni eseguite nel cloud:

- PHP lint, JavaScript syntax e `git diff --check`.
- 44 URL, un H1 e alternati IT/EN per ciascuno; asset locali, schede e stato HTTP 404 per progetto sconosciuto.
- Browser Chromium: pagine principali IT/EN, schede, filtri combinati per applicazione/materiale, cambio lingua sulla stessa scheda, menu mobile/Escape, validazione form e composizione email, prefers-reduced-motion. Nessun errore JavaScript rilevato.
- Nessun overflow orizzontale rilevato a 360, 390, 768 e 1440 px nelle sei pagine campionate.
- Axe WCAG 2 A/AA e 2.1 AA: nessuna violazione nelle pagine home, azienda, soluzioni, realizzazioni, contatti e home inglese. Le verifiche automatiche non sostituiscono una verifica assistiva manuale completa.
- Lighthouse mobile simulato sulla home: Performance 100, Accessibility 100, Best Practices 100, SEO 100; LCP 1.3 s, CLS 0, TBT 0 ms. Misurazione locale, non risultato di produzione. INP reale da verificare con dati di campo dopo la pubblicazione. Il portfolio raggiunge Performance 99, Accessibility 100, Best Practices 100, SEO 100, LCP 2,0 s e CLS 0. Un controllo Event Timing con 30 interazioni sui filtri ha osservato una durata massima di 24 ms; è un campione di laboratorio, non una misura INP di campo.

## Hero video 3D

Video illustrativo originale realizzato con Blender: cella di finitura, robot articolato, rulliera, stazione di pulitura e protezioni. Non è una ricostruzione tecnica di un impianto reale. Full HD su desktop, variante 720p per mobile, loop di 6 secondi privo di audio. Supporto pausa/riproduci, sospensione fuori schermo e a scheda nascosta, nessun caricamento automatico con `prefers-reduced-motion` o `saveData`. Sorgente, rigenerazione e verifica in [HERO-VIDEO.md](HERO-VIDEO.md). Le precedenti misure Lighthouse sono storiche; consultare il report aggiornato per la nuova hero.

## Rilascio e limiti

Distribuire file PHP e asset mantenendo maiuscole/minuscole e directory. Nessun database necessario per il sito pubblico. Sul server di produzione abilitare compressione HTTP e cache degli asset secondo la configurazione del servizio; ripetere Lighthouse sul dominio effettivo. La sitemap usa il dominio pubblico esistente.

Il gestionale conserva il problema preesistente: connessione al database remoto rifiutata. Non sono stati modificati parametri di produzione, credenziali, logica gestionale o dati. Non è stato eseguito un invio email reale. Il lavoro non è stato pubblicato sul sito pubblico.
