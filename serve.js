const { spawn, exec } = require('child_process');
const http = require('http');
const fs = require('fs');

const phpPath = fs.existsSync('C:\\xampp\\php\\php.exe')
  ? 'C:\\xampp\\php\\php.exe'
  : 'php';

console.log('===================================================');
console.log('  LinksBase - Web Tools Hub');
console.log('===================================================');
console.log('Starting PHP development server...');
console.log('URL: http://localhost:8000');
console.log('(Press Ctrl+C to stop)');
console.log('===================================================');

// Spawn the PHP server process
const server = spawn(phpPath, ['-S', 'localhost:8000'], {
  stdio: 'inherit'
});

let opened = false;

function checkAndOpen() {
  if (opened) return;
  const req = http.get('http://localhost:8000', (res) => {
    if (!opened) {
      opened = true;
      console.log('\n[LinksBase] Server confirmed LIVE (HTTP ' + res.statusCode + ')!');
      console.log('[LinksBase] Launching browser to http://localhost:8000 ...\n');
      exec('explorer "http://localhost:8000"');
    }
  });

  req.on('error', () => {
    if (!opened) {
      setTimeout(checkAndOpen, 200);
    }
  });
}

// Begin HTTP polling after 250ms
setTimeout(checkAndOpen, 250);

// Graceful cleanup on Ctrl+C
process.on('SIGINT', () => {
  server.kill('SIGINT');
  process.exit();
});
