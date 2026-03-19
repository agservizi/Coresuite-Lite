const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const baseUrl = process.env.CAPTURE_BASE_URL || 'http://127.0.0.1:8025';
const outputDir = path.resolve(process.cwd(), 'docs/screenshots/gumroad');
const chromePath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const desktopViewport = { width: 1728, height: 1117, deviceScaleFactor: 1 };

const shots = [
  { name: '01-login.png', path: '/login', auth: false, waitFor: '.login-stage' },
  { name: '02-dashboard.png', path: '/dashboard', auth: true, waitFor: '.dashboard-shell, .dashboard-grid, main' },
  { name: '03-tickets-board.png', path: '/tickets/board', auth: true, waitFor: '.board-shell, .kanban-board, main' },
  { name: '04-projects-board.png', path: '/projects/board', auth: true, waitFor: '.board-shell, .project-board, main' },
  { name: '05-sales-dashboard.png', path: '/sales', auth: true, waitFor: '.sales-shell, .sales-dashboard, main' },
  { name: '06-sales-pipeline.png', path: '/sales/pipeline', auth: true, waitFor: '.pipeline-shell, .sales-pipeline, main' },
  { name: '07-quote-create.png', path: '/sales/quotes/create', auth: true, waitFor: '.sales-form-shell, form, main' },
  { name: '08-invoice-create.png', path: '/sales/invoices/create', auth: true, waitFor: '.sales-form-shell, form, main' }
];

function ensureDir(dir) {
  fs.mkdirSync(dir, { recursive: true });
}

async function waitForOne(page, selectorList) {
  const selectors = selectorList.split(',').map((item) => item.trim()).filter(Boolean);
  for (const selector of selectors) {
    try {
      await page.waitForSelector(selector, { timeout: 4000 });
      return;
    } catch (_) {
      // try next selector
    }
  }
}

async function login(page) {
  await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle2', timeout: 30000 });
  await page.waitForSelector('input[name="email"]', { timeout: 10000 });
  await page.type('input[name="email"]', 'admin@example.com', { delay: 20 });
  await page.type('input[name="password"]', 'admin123', { delay: 20 });
  await Promise.all([
    page.click('button[type="submit"]'),
    page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 }),
  ]);

  if (page.url().includes('/login')) {
    throw new Error('Login failed, still on /login');
  }
}

async function capture() {
  ensureDir(outputDir);

  const browser = await puppeteer.launch({
    executablePath: fs.existsSync(chromePath) ? chromePath : undefined,
    headless: true,
    args: [
      '--no-sandbox',
      '--disable-setuid-sandbox',
      `--window-size=${desktopViewport.width},${desktopViewport.height}`,
    ],
    defaultViewport: null,
  });

  try {
    const page = await browser.newPage();
    await page.setViewport(desktopViewport);

    let loggedIn = false;

    for (const shot of shots) {
      if (shot.auth && !loggedIn) {
        await login(page);
        loggedIn = true;
      } else {
        await page.goto(`${baseUrl}${shot.path}`, { waitUntil: 'networkidle2', timeout: 30000 });
      }

      if (shot.waitFor) {
        await waitForOne(page, shot.waitFor);
      }

      await page.screenshot({
        path: path.join(outputDir, shot.name),
        fullPage: false,
      });

      console.log(`saved:${shot.name}`);
    }
  } finally {
    await browser.close();
  }
}

capture().catch((error) => {
  console.error(error);
  process.exit(1);
});
