(function () {
  const defaultApiBase = 'http://127.0.0.1:8000/api';
  const fromStorage = localStorage.getItem('SUPEREDU_AI_API_BASE');
  const fromWindow = typeof window.SUPEREDU_AI_API_BASE === 'string' ? window.SUPEREDU_AI_API_BASE : null;

  window.SUPEREDU_AI_API_BASE = (fromWindow || fromStorage || defaultApiBase).trim();
})();