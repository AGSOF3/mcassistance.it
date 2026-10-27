const assert = require('node:assert/strict');
const { chromium } = require(process.env.PLAYWRIGHT_MODULE || 'playwright');
const base = process.env.MC_BASE_URL || 'http://127.0.0.1:8080';
(async () => {
 const browser = await chromium.launch({executablePath: process.env.CHROME_PATH || '/usr/bin/chromium', args:['--no-sandbox']});
 try {
  const reduced = await browser.newContext({reducedMotion:'reduce', viewport:{width:1440,height:1000}});
  const page = await reduced.newPage();const requests=[];
  page.on('request', r=>{if(r.url().endsWith('.mp4'))requests.push(r.url())});
  for(const path of ['/','/en/']) {
   await page.goto(base+path);await page.waitForTimeout(500);
   assert.equal(await page.locator('.brand-logo[src="/assets/img/logop.png"]').count(),2);
   assert.equal(await page.locator('#hero-video').getAttribute('src'),null);
   assert.equal(await page.locator('#hero-video').evaluate(v=>v.paused),true);
  }
  assert.equal(requests.length,0,'Reduced motion must not download video');
  for(const path of ['/azienda/','/en/company/']){await page.goto(base+path);assert.equal(await page.locator('.team-grid').count(),0);assert.equal(await page.getByText('Giovanni Corsini').count(),0)}
  await page.goto(base+'/');await page.locator('#hero-video-toggle').click();
  await page.waitForFunction(()=>{let v=document.querySelector('#hero-video');return v.videoWidth===1920&&!v.paused&&v.currentTime>0});
  assert.equal(await page.locator('#hero-video').evaluate(v=>v.videoHeight),1080);
  await page.locator('#hero-video-toggle').click();assert.equal(await page.locator('#hero-video').evaluate(v=>v.paused),true);
  await reduced.close();
  const normal=await browser.newContext({viewport:{width:1440,height:1000}});const desktop=await normal.newPage();
  await desktop.goto(base+'/');await desktop.waitForFunction(()=>{let v=document.querySelector('#hero-video');return v.videoWidth===1920&&v.currentTime>0&&!v.paused});
  await desktop.locator('footer').scrollIntoViewIfNeeded();await desktop.waitForTimeout(250);assert.equal(await desktop.locator('#hero-video').evaluate(v=>v.paused),true);
  await desktop.evaluate(()=>scrollTo(0,0));await desktop.waitForFunction(()=>!document.querySelector('#hero-video').paused);
  await desktop.emulateMedia({reducedMotion:'reduce'});await desktop.waitForFunction(()=>document.querySelector('#hero-video').paused);
  await normal.close();
  const mobile=await browser.newContext({viewport:{width:390,height:844}});const small=await mobile.newPage();await small.goto(base+'/');await small.waitForFunction(()=>document.querySelector('#hero-video').videoWidth===1280);
  assert.equal(await small.locator('#hero-video').evaluate(v=>v.videoHeight),720);assert.equal(await small.evaluate(()=>document.documentElement.scrollWidth>innerWidth),false);await mobile.close();
  const saver=await browser.newContext();await saver.addInitScript(()=>Object.defineProperty(navigator,'connection',{value:{saveData:true,addEventListener(){}}}));const saved=await saver.newPage();await saved.goto(base+'/');await saved.waitForTimeout(300);assert.equal(await saved.locator('#hero-video').getAttribute('src'),null);await saver.close();
  const unavailable=await browser.newContext();const fallback=await unavailable.newPage();await fallback.route('**/robotic-cell-*.mp4',route=>route.abort());await fallback.goto(base+'/');await fallback.waitForFunction(()=>Boolean(document.querySelector('#hero-video').error));assert.equal(await fallback.locator('#hero-video-toggle').isVisible(),false);assert.equal(await fallback.locator('#hero-video').evaluate(v=>getComputedStyle(v).opacity),'0');assert.equal(await fallback.locator('.hero-img').isVisible(),true);await unavailable.close();
  console.log('PASS hero: IT/EN original logo, no team section, Full HD desktop / 720p mobile, playback/pause, offscreen suspension, reduced motion and data saving.');
 } finally {await browser.close()}
})().catch(error=>{console.error(error);process.exit(1)});
