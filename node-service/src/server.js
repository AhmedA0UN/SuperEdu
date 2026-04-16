const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const compression = require('compression');
const morgan = require('morgan');
const axios = require('axios');
const dotenv = require('dotenv');

dotenv.config();

const app = express();

const PORT = Number(process.env.PORT || 4000);
const LARAVEL_API_URL = process.env.LARAVEL_API_URL || 'http://localhost:8000/api';
const FRONTEND_URL = process.env.FRONTEND_URL || 'http://localhost:5173';

app.use(
  helmet({
    crossOriginResourcePolicy: { policy: 'cross-origin' },
  }),
);
app.use(compression());
app.use(cors({ origin: FRONTEND_URL }));
app.use(express.json({ limit: '1mb' }));
app.use(morgan('combined'));

app.get('/health', (_req, res) => {
  res.status(200).json({
    service: 'bestedu-node-service',
    status: 'ok',
    timestamp: new Date().toISOString(),
  });
});

app.get('/api/status', async (_req, res) => {
  let laravel = { status: 'unknown' };

  try {
    const response = await axios.get(`${LARAVEL_API_URL}/health`, { timeout: 3000 });
    laravel = response.data;
  } catch (_error) {
    laravel = { status: 'down' };
  }

  res.status(200).json({
    project: 'BestEdu production stack',
    frontend: FRONTEND_URL,
    node: {
      status: 'ok',
      port: PORT,
    },
    laravel,
  });
});

app.listen(PORT, () => {
  // Startup log for container/platform diagnostics.
  console.log(`Node service listening on port ${PORT}`);
});
