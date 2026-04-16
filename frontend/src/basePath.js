const rawBasePath = import.meta.env.BASE_URL || '/'

export const appBasePath = rawBasePath === '/' ? '/' : rawBasePath.replace(/\/$/, '')

export function withBasePath(path) {
  const normalizedPath = path.startsWith('/') ? path.slice(1) : path
  const normalizedBase = appBasePath === '/' ? '/' : `${appBasePath}/`

  return `${normalizedBase}${normalizedPath}`
}