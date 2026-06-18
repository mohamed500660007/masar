import portraitImage from "../imports/ChatGPT_Image_Jun_5__2026__09_44_16_PM.png";
import {
  ArrowRight,
  Network,
  Database,
  Code2,
  Layers,
  BookOpen,
  Zap,
  Target,
  Clock,
  Cpu,
  Github,
  Twitter,
  Linkedin,
  ChevronRight,
} from "lucide-react";

// ─── Data ────────────────────────────────────────────────────────────────────

const TOPICS = [
  {
    icon: Network,
    title: "Networking",
    desc: "TCP/IP, DNS, HTTP, and how data actually travels across machines.",
  },
  {
    icon: Cpu,
    title: "Operating Systems",
    desc: "Processes, memory management, scheduling, and the kernel.",
  },
  {
    icon: Database,
    title: "Databases",
    desc: "Indexing, transactions, query optimization, and storage engines.",
  },
  {
    icon: Code2,
    title: "Backend Engineering",
    desc: "APIs, caching, message queues, and service architecture.",
  },
  {
    icon: Layers,
    title: "System Design",
    desc: "Scalability patterns and trade-offs for real-world systems.",
  },
];

const ARTICLES = [
  {
    category: "Networking",
    readTime: "8 min",
    title: "TCP vs UDP",
    subtitle: "What Actually Happens When Data Travels?",
    image:
      "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=640&h=360&fit=crop&auto=format",
  },
  {
    category: "Operating Systems",
    readTime: "12 min",
    title: "Inside the Linux Process Model",
    subtitle: "Fork, exec, signals, and how the kernel manages it all.",
    image:
      "https://images.unsplash.com/photo-1629654297299-c8506221ca97?w=640&h=360&fit=crop&auto=format",
  },
  {
    category: "Databases",
    readTime: "10 min",
    title: "Database Indexing Explained Deep",
    subtitle: "B-trees, hash indexes, and when each one wins.",
    image:
      "https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=640&h=360&fit=crop&auto=format",
  },
];

const CHALLENGES = [
  {
    num: "01",
    difficulty: "Medium" as const,
    title: "A payment service starts timing out under heavy load.",
  },
  {
    num: "02",
    difficulty: "Hard" as const,
    title: "The database suddenly becomes the bottleneck at 10k req/s.",
  },
  {
    num: "03",
    difficulty: "Medium" as const,
    title: "Users in Europe experience high latency on every request.",
  },
  {
    num: "04",
    difficulty: "Hard" as const,
    title: "Memory usage keeps growing until the process crashes.",
  },
];

const FEATURES = [
  {
    icon: BookOpen,
    title: "Structured Learning",
    desc: "Each topic builds on the previous. A real curriculum, not a blog feed.",
  },
  {
    icon: Target,
    title: "Real Scenarios",
    desc: "Every challenge is based on real production incidents engineers face.",
  },
  {
    icon: Zap,
    title: "Deep Understanding",
    desc: "First principles. Not surface-level summaries or tutorial code.",
  },
];

// ─── Shared ───────────────────────────────────────────────────────────────────

function GoogleIcon() {
  return (
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
      <path
        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
        fill="#4285F4"
      />
      <path
        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
        fill="#34A853"
      />
      <path
        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
        fill="#FBBC05"
      />
      <path
        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
        fill="#EA4335"
      />
    </svg>
  );
}

function SectionLabel({ children }: { children: React.ReactNode }) {
  return (
    <span className="block text-[11px] tracking-[0.2em] text-muted-foreground font-medium uppercase mb-4 font-sans">
      {children}
    </span>
  );
}

// ─── Navigation ───────────────────────────────────────────────────────────────

function Nav() {
  return (
    <header
      className="fixed top-0 left-0 right-0 z-50 border-b border-border"
      style={{ backdropFilter: "blur(12px)", backgroundColor: "rgba(11,11,11,0.85)" }}
    >
      <div className="max-w-[1280px] mx-auto px-8 h-[60px] flex items-center justify-between">
        <div className="flex items-center gap-3">
          <div
            className="w-8 h-8 flex items-center justify-center rounded"
            style={{ backgroundColor: "#8B6B4A" }}
          >
            <span
              className="text-[11px] font-bold tracking-widest text-white"
              style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
            >
              MS
            </span>
          </div>
        </div>

        <nav className="flex items-center gap-7">
          {["Topics", "Articles", "Challenges", "About"].map((link) => (
            <a
              key={link}
              href="#"
              className="text-[13px] text-muted-foreground hover:text-foreground transition-colors duration-150 font-sans"
            >
              {link}
            </a>
          ))}
        </nav>

        <button className="flex items-center gap-2 px-4 py-[7px] text-[13px] border border-border rounded text-muted-foreground hover:text-foreground hover:border-white/15 transition-colors duration-150 font-sans">
          <GoogleIcon />
          Sign in with Google
        </button>
      </div>
    </header>
  );
}

// ─── Hero ─────────────────────────────────────────────────────────────────────

function Hero() {
  return (
    <section className="pt-[60px]">
      <div className="max-w-[1280px] mx-auto px-8">
        <div
          className="grid"
          style={{
            gridTemplateColumns: "1fr 460px",
            minHeight: "calc(100vh - 60px)",
          }}
        >
          {/* Left */}
          <div className="flex flex-col justify-center py-24 pr-20">
            <SectionLabel>Software Engineering</SectionLabel>

            <h1
              className="text-[3.75rem] leading-[1.04] font-extrabold text-foreground mb-7 tracking-tight"
              style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
            >
              Software Engineering
              <br />
              <span style={{ color: "#8B6B4A" }}>Without The Noise</span>
            </h1>

            <div className="mb-9 space-y-0.5">
              <p className="text-muted-foreground text-[17px] leading-relaxed font-sans">
                Operating Systems. Networking.
              </p>
              <p className="text-muted-foreground text-[17px] leading-relaxed font-sans">
                Databases. Backend Engineering.
              </p>
              <p
                className="text-[17px] leading-relaxed mt-4 font-sans"
                style={{ color: "#F7F5F2" }}
              >
                Structured learning for engineers who want deep understanding.
              </p>
            </div>

            <div className="flex items-center gap-4 mb-11">
              <button
                className="inline-flex items-center gap-2 px-6 py-[11px] text-[13px] font-medium rounded text-white transition-opacity duration-150 hover:opacity-90 font-sans"
                style={{ backgroundColor: "#8B6B4A" }}
              >
                Start Learning
                <ArrowRight size={14} />
              </button>
            </div>

            <div className="flex items-center gap-3">
              <div className="flex -space-x-1.5">
                {[
                  "from-[#A67C52] to-[#6B4C30]",
                  "from-[#7A5C3E] to-[#503C28]",
                  "from-[#C49A6C] to-[#8B6B4A]",
                  "from-[#5C4330] to-[#3A2A1C]",
                ].map((gradient, i) => (
                  <div
                    key={i}
                    className={`w-6 h-6 rounded-full border-2 bg-gradient-to-br ${gradient}`}
                    style={{ borderColor: "#0B0B0B" }}
                  />
                ))}
              </div>
              <span className="text-[13px] text-muted-foreground font-sans">
                Join{" "}
                <span className="text-foreground font-medium">1,200+</span>{" "}
                engineers learning and growing.
              </span>
            </div>
          </div>

          {/* Right — Portrait */}
          <div className="relative overflow-hidden" style={{ backgroundColor: "#0f0c09" }}>
            <img
              src={portraitImage}
              alt="Software engineering educator"
              className="absolute inset-0 w-full h-full object-cover object-top"
              style={{ objectPosition: "50% 8%" }}
            />
            {/* Left blend */}
            <div
              className="absolute inset-y-0 left-0 w-28 pointer-events-none"
              style={{
                background: "linear-gradient(to right, #0B0B0B, transparent)",
              }}
            />
            {/* Bottom fade */}
            <div
              className="absolute bottom-0 left-0 right-0 h-52 pointer-events-none"
              style={{
                background: "linear-gradient(to top, #0B0B0B 10%, transparent)",
              }}
            />
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Topics ───────────────────────────────────────────────────────────────────

function Topics() {
  return (
    <section className="py-24 border-t border-border">
      <div className="max-w-[1280px] mx-auto px-8">
        <div className="mb-12">
          <SectionLabel>Browse</SectionLabel>
          <h2
            className="text-[2.25rem] font-bold text-foreground tracking-tight"
            style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
          >
            Browse by Topic
          </h2>
        </div>

        <div className="grid grid-cols-5 gap-3">
          {TOPICS.map((topic) => {
            const Icon = topic.icon;
            return (
              <a
                key={topic.title}
                href="#"
                className="group p-5 bg-card border border-border rounded-lg hover:border-white/[0.14] transition-all duration-200 flex flex-col"
                style={{ backgroundColor: "#121212" }}
              >
                <div
                  className="w-8 h-8 flex items-center justify-center rounded border border-border mb-5 text-muted-foreground group-hover:text-foreground group-hover:border-white/[0.14] transition-colors duration-200"
                >
                  <Icon size={16} />
                </div>
                <h3
                  className="font-semibold text-foreground text-[14px] mb-2 leading-snug"
                  style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
                >
                  {topic.title}
                </h3>
                <p className="text-muted-foreground text-[13px] leading-relaxed mb-5 flex-1 font-sans">
                  {topic.desc}
                </p>
                <div
                  className="flex items-center gap-0.5 text-[12px] font-medium font-sans"
                  style={{ color: "#8B6B4A" }}
                >
                  Explore
                  <ChevronRight size={11} />
                </div>
              </a>
            );
          })}
        </div>
      </div>
    </section>
  );
}

// ─── Articles ─────────────────────────────────────────────────────────────────

function Articles() {
  return (
    <section className="py-24 border-t border-border">
      <div className="max-w-[1280px] mx-auto px-8">
        <div className="mb-12">
          <SectionLabel>Featured Articles</SectionLabel>
          <h2
            className="text-[2.25rem] font-bold text-foreground tracking-tight"
            style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
          >
            Read. Understand. Grow.
          </h2>
        </div>

        <div className="grid grid-cols-3 gap-5">
          {ARTICLES.map((article) => (
            <a
              key={article.title}
              href="#"
              className="group flex flex-col bg-card border border-border rounded-lg overflow-hidden hover:border-white/[0.14] transition-all duration-200"
              style={{ backgroundColor: "#121212" }}
            >
              {/* Image */}
              <div className="relative overflow-hidden bg-secondary h-44 shrink-0">
                <img
                  src={article.image}
                  alt={article.title}
                  className="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500"
                />
                <div className="absolute inset-0 bg-black/20" />
              </div>

              {/* Content */}
              <div className="p-6 flex flex-col flex-1">
                <div className="flex items-center gap-3 mb-4">
                  <span
                    className="text-[11px] font-medium px-2.5 py-0.5 rounded-full border font-sans"
                    style={{
                      color: "#8B6B4A",
                      borderColor: "rgba(139,107,74,0.3)",
                      backgroundColor: "rgba(139,107,74,0.08)",
                    }}
                  >
                    {article.category}
                  </span>
                  <div className="flex items-center gap-1 text-muted-foreground font-sans">
                    <Clock size={11} />
                    <span className="text-[12px]">{article.readTime}</span>
                  </div>
                </div>

                <h3
                  className="font-bold text-foreground text-[1.2rem] mb-2 leading-tight"
                  style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
                >
                  {article.title}
                </h3>
                <p className="text-muted-foreground text-[13px] leading-relaxed mb-5 flex-1 font-sans">
                  {article.subtitle}
                </p>

                <div
                  className="flex items-center gap-1 text-[13px] font-medium font-sans group-hover:gap-1.5 transition-all duration-150"
                  style={{ color: "#8B6B4A" }}
                >
                  Read article
                  <ArrowRight size={13} />
                </div>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Challenges ───────────────────────────────────────────────────────────────

function Challenges() {
  return (
    <section className="py-24 border-t border-border">
      <div className="max-w-[1280px] mx-auto px-8">
        <div className="mb-12">
          <SectionLabel>Engineering Challenges</SectionLabel>
          <h2
            className="text-[2.25rem] font-bold text-foreground tracking-tight"
            style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
          >
            Practice with Real Scenarios
          </h2>
        </div>

        <div className="grid grid-cols-2 gap-3">
          {CHALLENGES.map((challenge) => (
            <div
              key={challenge.num}
              className="group flex items-start gap-6 p-7 bg-card border border-border rounded-lg hover:border-white/[0.14] transition-all duration-200"
              style={{ backgroundColor: "#121212" }}
            >
              <span
                className="text-[2rem] font-bold leading-none mt-0.5 shrink-0 font-sans tabular-nums"
                style={{ color: "rgba(255,255,255,0.06)" }}
              >
                {challenge.num}
              </span>

              <div className="flex-1 min-w-0">
                <div className="mb-3">
                  <span
                    className="text-[11px] font-medium px-2.5 py-0.5 rounded-full border font-sans"
                    style={
                      challenge.difficulty === "Hard"
                        ? {
                            color: "#f87171",
                            borderColor: "rgba(248,113,113,0.2)",
                            backgroundColor: "rgba(248,113,113,0.06)",
                          }
                        : {
                            color: "#fbbf24",
                            borderColor: "rgba(251,191,36,0.2)",
                            backgroundColor: "rgba(251,191,36,0.06)",
                          }
                    }
                  >
                    {challenge.difficulty}
                  </span>
                </div>

                <p className="text-foreground text-[15px] font-medium leading-snug mb-5 font-sans">
                  {challenge.title}
                </p>

                <button
                  className="text-[13px] font-medium flex items-center gap-1 group-hover:gap-1.5 transition-all duration-150 font-sans"
                  style={{ color: "#8B6B4A" }}
                >
                  Solve
                  <ArrowRight size={12} />
                </button>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── Why ──────────────────────────────────────────────────────────────────────

function Why() {
  return (
    <section className="py-24 border-t border-border">
      <div className="max-w-[1280px] mx-auto px-8">
        <div
          className="grid gap-20 items-start"
          style={{ gridTemplateColumns: "1fr 1fr" }}
        >
          {/* Left */}
          <div>
            <SectionLabel>Why This Site</SectionLabel>
            <h2
              className="text-[2.8rem] font-bold text-foreground leading-[1.1] tracking-tight mb-8"
              style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
            >
              Built for Engineers,
              <br />
              By an Engineer.
            </h2>
            <div className="space-y-2">
              <p className="text-muted-foreground text-[17px] leading-relaxed font-sans">
                I share what actually matters from real experience.
              </p>
              <p className="text-muted-foreground text-[17px] leading-relaxed font-sans">
                No fluff.
              </p>
              <p className="text-muted-foreground text-[17px] leading-relaxed font-sans">
                No shortcuts.
              </p>
              <p
                className="text-[17px] leading-relaxed font-medium mt-2 font-sans"
                style={{ color: "#DCCBB7" }}
              >
                Just deep understanding.
              </p>
            </div>
          </div>

          {/* Right — Feature cards */}
          <div className="flex flex-col gap-3 pt-14">
            {FEATURES.map((feature) => {
              const Icon = feature.icon;
              return (
                <div
                  key={feature.title}
                  className="flex items-start gap-4 p-5 bg-card border border-border rounded-lg"
                  style={{ backgroundColor: "#121212" }}
                >
                  <div className="w-8 h-8 flex items-center justify-center rounded border border-border text-muted-foreground shrink-0 mt-0.5">
                    <Icon size={15} />
                  </div>
                  <div>
                    <h4
                      className="font-semibold text-foreground text-[14px] mb-1.5 leading-snug"
                      style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
                    >
                      {feature.title}
                    </h4>
                    <p className="text-muted-foreground text-[13px] leading-relaxed font-sans">
                      {feature.desc}
                    </p>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── Footer ───────────────────────────────────────────────────────────────────

function Footer() {
  return (
    <footer className="border-t border-border">
      {/* CTA strip */}
      <div className="py-16 border-b border-border">
        <div className="max-w-[1280px] mx-auto px-8 flex items-center justify-between">
          <div>
            <h3
              className="text-[1.5rem] font-bold text-foreground mb-1.5 tracking-tight"
              style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
            >
              Ready to level up?
            </h3>
            <p className="text-muted-foreground text-[13px] font-sans">
              Start learning today. No subscription required.
            </p>
          </div>
          <button className="flex items-center gap-2 px-5 py-[10px] border border-border rounded text-[13px] text-muted-foreground hover:text-foreground hover:border-white/15 transition-colors duration-150 font-sans">
            <GoogleIcon />
            Sign in with Google
          </button>
        </div>
      </div>

      {/* Links row */}
      <div className="py-10">
        <div className="max-w-[1280px] mx-auto px-8 flex items-center justify-between">
          {/* Logo */}
          <div className="flex items-center gap-2.5">
            <div
              className="w-7 h-7 flex items-center justify-center rounded"
              style={{ backgroundColor: "#8B6B4A" }}
            >
              <span
                className="text-[10px] font-bold tracking-widest text-white"
                style={{ fontFamily: "'Cabinet Grotesk', sans-serif" }}
              >
                MS
              </span>
            </div>
            <span className="text-foreground text-[13px] font-medium font-sans">
              Mustafa Sami
            </span>
          </div>

          {/* Nav links */}
          <div className="flex items-center gap-7">
            {["Topics", "Articles", "Challenges", "About"].map((link) => (
              <a
                key={link}
                href="#"
                className="text-[13px] text-muted-foreground hover:text-foreground transition-colors font-sans"
              >
                {link}
              </a>
            ))}
          </div>

          {/* Social */}
          <div className="flex items-center gap-2">
            {[
              { Icon: Twitter, label: "Twitter" },
              { Icon: Github, label: "GitHub" },
              { Icon: Linkedin, label: "LinkedIn" },
            ].map(({ Icon, label }) => (
              <a
                key={label}
                href="#"
                aria-label={label}
                className="w-8 h-8 flex items-center justify-center border border-border rounded text-muted-foreground hover:text-foreground hover:border-white/15 transition-colors"
              >
                <Icon size={14} />
              </a>
            ))}
          </div>
        </div>
      </div>

      {/* Bottom */}
      <div className="py-5 border-t border-border">
        <div className="max-w-[1280px] mx-auto px-8 flex items-center justify-between">
          <p className="text-[12px] text-muted-foreground font-sans">
            © 2026 Mustafa Sami. All rights reserved.
          </p>
          <p className="text-[12px] text-muted-foreground font-sans">
            Built for engineers who care about the craft.
          </p>
        </div>
      </div>
    </footer>
  );
}

// ─── App ──────────────────────────────────────────────────────────────────────

export default function App() {
  return (
    <div className="min-h-screen bg-background text-foreground font-sans">
      <Nav />
      <main>
        <Hero />
        <Topics />
        <Articles />
        <Challenges />
        <Why />
      </main>
      <Footer />
    </div>
  );
}
