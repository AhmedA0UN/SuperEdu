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
      <header className="hero hero-superbot">
        <p className="eyebrow">Interface IA</p>
        <h1>SuperBot IA</h1>
        <p>Assistant pedagogique en direct pour les revisions, le debug et les quiz.</p>
      </header>

      <section className="superbot-card" aria-label="Assistant SuperBot IA">
        <div className="superbot-header">
          <div className="superbot-avatar" aria-hidden="true">🤖</div>
          <div>
            <h2>SuperBot IA</h2>
            <p className="superbot-status">
              <span className="status-dot" aria-hidden="true" /> En ligne · Pret a aider
            </p>
          </div>
        </div>

        <div className="superbot-message-box">
          <p className="superbot-message">
            🎓 Bonjour Ahmed ! Je vois que tu progresses bien sur les Design Patterns.
            Veux-tu que je t&apos;explique le Pattern Observer ?
          </p>

          <div className="superbot-suggestions">
            <button type="button" className="chip">❓ Explique Observer</button>
            <button type="button" className="chip">📄 Fiche Revision</button>
            <button type="button" className="chip">🧩 Debug Code</button>
            <button type="button" className="chip">❔ Quiz</button>
            <button type="button" className="chip">••• Avance</button>
          </div>
        </div>

        <div className="superbot-input-row">
          <input
            type="text"
            placeholder="Pose ta question a SuperBot..."
            aria-label="Question pour SuperBot"
          />
          <button type="button" className="icon-btn" aria-label="Demarrer la saisie vocale">
            🎤
          </button>
          <button type="button" className="icon-btn" aria-label="Envoyer le message">
            📨
          </button>
        </div>
      </section>

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
