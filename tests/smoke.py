"""Check published routes and all local assets without third-party dependencies."""
import os
from urllib.request import urlopen
from urllib.parse import urljoin, urlparse
from html.parser import HTMLParser
from xml.etree import ElementTree
BASE = os.environ.get('MC_BASE_URL', 'http://127.0.0.1:8080').rstrip('/')
ROOT = os.path.dirname(os.path.dirname(__file__))
class Page(HTMLParser):
    def __init__(self):
        super().__init__(); self.assets = []; self.h1 = 0; self.languages = []
    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if tag == 'h1': self.h1 += 1
        if tag in ('img', 'script', 'source') and 'src' in a: self.assets.append(a['src'])
        if tag == 'video':
            self.assets.extend(a[key] for key in ('data-desktop-src', 'data-mobile-src') if key in a)
        if tag in ('img', 'source') and 'srcset' in a:
            self.assets.extend(part.strip().split()[0] for part in a['srcset'].split(','))
        if tag == 'link' and a.get('rel') in ('stylesheet', 'icon'): self.assets.append(a['href'])
        if tag == 'link' and a.get('rel') == 'alternate': self.languages.append(a.get('hreflang'))
routes = ElementTree.parse(os.path.join(ROOT, 'sitemap.xml')).getroot()
assets = set()
for route in routes:
    path = route[0].text.removeprefix('https://www.mcassistance.it')
    with urlopen(BASE + path, timeout=10) as response:
        assert response.status == 200, path
        page = Page(); page.feed(response.read().decode())
        assert page.h1 == 1, path
        assert set(page.languages) == {'it', 'en'}, path
        for asset in page.assets:
            if asset.startswith('/'): assets.add(asset)
for asset in assets:
    with urlopen(urljoin(BASE + '/', asset), timeout=10) as response:
        assert response.status == 200 and response.read(1), asset
print(f'PASS: {len(routes)} routes, one H1 and IT/EN alternates per route; {len(assets)} local assets.')
try:
    urlopen(BASE + '/realizzazioni/?progetto=does-not-exist', timeout=10)
    raise AssertionError('Invalid project must return 404')
except Exception as exc:
    assert getattr(exc, 'code', None) == 404, exc
print('PASS: unknown project returns HTTP 404.')
