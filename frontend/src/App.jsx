import { Link, Navigate, Route, Routes } from 'react-router-dom'
import { withBasePath } from './basePath'

const pages = [
  {
    route: '/index',
    title: 'Plateforme Principale',
    description: 'Interface principale Super_Edu.',
    src: withBasePath('/super_edu/index.html'),
  },
  {
    route: '/certification',
    title: 'Certification',
    description: 'Page de certification Super_Edu.',
    src: withBasePath('/super_edu/Wpages/certification.html'),
  },
  {
    route: '/conseils',
    title: 'Conseils',
    description: 'Page de conseils pedagogiques.',
    src: withBasePath('/super_edu/Wpages/conseils.html'),
  },
  {
    route: '/mentor-ia',
    title: 'Mentor IA',
    description: 'Page mentor IA et accompagnement.',
    src: withBasePath('/super_edu/Wpages/mentor%20IA.html'),
  },
  {
    route: '/prototype',
    title: 'Prototype',
    description: 'Prototype d interface de Super_Edu.',
    src: withBasePath('/super_edu/Wpages/prototype.html'),
  },
  {
    route: '/weeeelcom',
    title: 'Weeeelcom',
    description: 'Page d accueil alternative.',
    src: withBasePath('/super_edu/Wpages/weeeelcom.html'),
  },
]

function LegacyFrame({ title, src }) {
  return (
    <section className="frame-shell">
      <div className="frame-header">
        <h2>{title}</h2>
        <a className="open-direct" href={src} target="_blank" rel="noreferrer">
          Ouvrir en plein ecran
        </a>
      </div>
      <iframe className="legacy-frame" title={title} src={src} />
    </section>
  )
}

function HomePage() {
  return (
    <main className="home">
      <header className="hero">
        <p className="eyebrow">Super_Edu Production</p>
        <h1>Node.js + React.js + Laravel</h1>
        <p>
          Memes composantes et memes interfaces de Super_Edu, encapsulees dans une
          architecture production moderne.
        </p>
      </header>

      <section className="grid">
        {pages.map((page) => (
          <article className="card" key={page.route}>
            <h3>{page.title}</h3>
            <p>{page.description}</p>
            <Link className="go" to={page.route}>
              Ouvrir
            </Link>
          </article>
        ))}
      </section>
    </main>
  )
}

function App() {
  return (
    <div className="app">
      <nav className="top-nav">
        <Link to="/">Accueil</Link>
        {pages.map((page) => (
          <Link key={page.route} to={page.route}>
            {page.title}
          </Link>
        ))}
      </nav>

      <Routes>
        <Route path="/" element={<HomePage />} />
        {pages.map((page) => (
          <Route
            key={page.route}
            path={page.route}
            element={<LegacyFrame title={page.title} src={page.src} />}
          />
        ))}
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </div>
  )
}

export default App
