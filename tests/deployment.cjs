// Run against the root or any installation prefix using MC_BASE_URL.
const assert = require('node:assert/strict');
const {chromium} = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
const base = (process.env.MC_BASE_URL || 'http://127.0.0.1:8080').replace(/\/$/,'');
const prefix = new URL(base).pathname.replace(/\/$/,'');
(async()=>{
 const browser=await chromium.launch({executablePath:process.env.CHROME_PATH||'/usr/bin/chromium',args:['--no-sandbox']});
 try {
  const context=await browser.newContext({reducedMotion:'reduce'});const page=await context.newPage();const failures=[];
  page.on('pageerror',error=>failures.push(error.message));
  page.on('response',response=>{if(response.url().startsWith(base+'/')&&response.status()>=400)failures.push(response.status()+' '+response.url())});
  for(const path of ['/','/en/','/azienda/','/en/company/','/soluzioni/','/contatti/','/realizzazioni/','/en/projects/','/privacy/']){
   assert.equal((await page.goto(base+path)).status(),200);
   assert.equal(await page.locator('body').getAttribute('data-site-base'),prefix+'/');
   assert((await page.locator('h1').evaluate(h=>parseFloat(getComputedStyle(h).fontSize)))>40);
   const links=await page.locator('a[href^="/"]').evaluateAll(elements=>elements.map(e=>e.getAttribute('href')));
   assert(links.every(link=>link==='/CadTimbratore/area-riservata/'||link.startsWith(prefix+'/')),path+' escaped prefix');
   const canonical=await page.locator('link[rel=canonical]').getAttribute('href');assert(canonical.startsWith('https://www.mcassistance.it'+prefix+'/'));
   assert.equal(await page.locator('.hero-video').count(),path==='/'||path==='/en/'?1:0);
  }
  for(const width of [390,1440]){await page.setViewportSize({width,height:900});await page.goto(base+'/');assert.equal(await page.evaluate(()=>document.documentElement.scrollWidth>innerWidth),false)}
  await page.locator('#hero-video-toggle').click();await page.waitForFunction(()=>{const video=document.querySelector('#hero-video');return video.videoWidth===1920&&!video.paused&&video.currentTime>0});
  assert((await page.locator('#hero-video').getAttribute('src')).startsWith(prefix+'/assets/video/'));
  await page.goto(base+'/realizzazioni/');await page.locator('[data-filter=manual]').click();assert.equal(await page.locator('.project-card:visible').count(),2);await page.locator('.project-card:visible a').first().click();assert(page.url().startsWith(base+'/realizzazioni/?progetto='));const project=new URL(page.url()).searchParams.get('progetto');
  await page.locator('.language').click();assert(page.url().startsWith(base+'/en/projects/?progetto='+project));
  await page.goto(base+'/#about');await page.waitForURL(base+'/azienda/');await page.goto(base+'/en/#contact');await page.waitForURL(base+'/en/contact/');
  assert.deepEqual(failures,[]);console.log('PASS deployment '+base+': CSS, assets, pages, canonical, navigation, language, project filters, hero playback and legacy anchors.');
 } finally {await browser.close()}
})().catch(error=>{console.error(error);process.exit(1)});
