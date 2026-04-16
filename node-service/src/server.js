const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const compression = require('compression');
const morgan = require('morgan');
const axios = require('axios');
const dotenv = require('dotenv');

dotenv.config();

const app = express();
app.disable('x-powered-by');

const PORT = Number(process.env.PORT || 4000);
const LARAVEL_API_URL = process.env.LARAVEL_API_URL || 'http://localhost:8000/api';
const FRONTEND_ORIGINS = (process.env.FRONTEND_ORIGINS || process.env.FRONTEND_URL || 'http://localhost:5173')
  .split(',')
  .map((origin) => origin.trim())
  .filter(Boolean);

app.use(
  helmet({
    crossOriginResourcePolicy: { policy: 'cross-origin' },
  }),
);
app.use(compression());
app.use(
  cors({
    origin(origin, callback) {
      if (!origin || FRONTEND_ORIGINS.includes('*') || FRONTEND_ORIGINS.includes(origin)) {
        return callback(null, true);
      }

      return callback(null, false);
    },
  }),
);
app.use(express.json({ limit: '1mb' }));
app.use(morgan('combined'));

app.get('/health', (_req, res) => {
  res.status(200).json({
    service: 'bestedu-node-service',
    status: 'ok',
    timestamp: new Date().toISOString(),
  });
});

app.get('/ready', async (_req, res) => {
  try {
    await axios.get(`${LARAVEL_API_URL}/health`, { timeout: 3000 });

    res.status(200).json({
      service: 'bestedu-node-service',
      status: 'ready',
      dependencies: {
        laravel: 'ok',
      },
      allowedOrigins: FRONTEND_ORIGINS,
      timestamp: new Date().toISOString(),
    });
  } catch (_error) {
    res.status(503).json({
      service: 'bestedu-node-service',
      status: 'not-ready',
      dependencies: {
        laravel: 'down',
      },
      allowedOrigins: FRONTEND_ORIGINS,
      timestamp: new Date().toISOString(),
    });
  }
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

const server = app.listen(PORT, () => {
  console.log(`Node service listening on port ${PORT}`);
});

function shutdown(signal) {
  console.log(`${signal} received, shutting down Node service`);

  server.close(() => {
    process.exit(0);
  });

  setTimeout(() => {
    process.exit(1);
  }, 5000).unref();
}

process.on('SIGINT', () => shutdown('SIGINT'));
process.on('SIGTERM', () => shutdown('SIGTERM'));
