const puppeteer = require('puppeteer');
const fs = require('fs');
const outDir = 'coresuite/screenshots-updated';
if(!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });
(async ()=>{
  const browser = await puppeteer.launch({ args:['--no-sandbox','--disable-setuid-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 720 });

  const targets = [
    { url: 'http://localhost:8000/preview.html', name: 'preview' },
    { url: 'http://localhost:8000/dev_dashboard.php', name: 'dashboard' }
  ];

  for(const t of targets){
    try{
      await page.goto(t.url, { waitUntil: 'networkidle2', timeout: 30000 });
      // wait a bit for charts to render
      await new Promise(r => setTimeout(r, 1200));
      const path = `${outDir}/${t.name}.png`;
      await page.screenshot({ path, fullPage: true });
      console.log('Saved', path);
    }catch(e){ console.error('Error capturing', t.url, e.message); }
  }

  await browser.close();
})();
