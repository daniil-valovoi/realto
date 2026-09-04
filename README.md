# Realto - Miami Real Estate Platform

<img width="1231" height="572" alt="realto" src="https://github.com/user-attachments/assets/4a35844b-6177-41a4-ad73-79e73602e649" />

A Miami-area real estate web platform where users can list, search, rent, and buy properties.

> **Note:** This is my first serious web project and is more than 2 yrs old. It may contain security vulnerabilities, unfinished features, or irrational design decisions. Not intended for production use or serious judgement (lol).

## Functionality

- Listing properties
- Creating listings (rent/sell) with owned properties
- Browse property listings (rent/buy)
- User accounts with roles (buyer, agent, admin)
- Account, listings, properties management via the dashboard
- Admin dashboard
- Session-based authentication with HMAC-signed cookies

## Built with

- **PHP** — vanilla, no framework. Shared hosting
- **JavaScript** — ES modules, no bundler
- **SCSS** — compiled to CSS
- **MariaDB** — relational database, `mysqli`
- **HTML** — PHP-rendered pages with PHP insertions (dynamic data display/components)
- **Designed in Figma by me** - the design is [here](https://www.figma.com/design/KUU5umFI0AdA7LCqZNEcGq/Realto-Website?node-id=0-1&p=f)

## Structure

```
root/
├── realto/   # Web root
│   ├── pages/            # PHP page files
│   ├── blocks/           # Shared UI blocks
│   ├── scripts/          # PHP API endpoints + JS modules
│   └── styles/           # SCSS source + compiled CSS
└── database-setup.sql    # DB schema
```

## Docs & Try It Out

Technical documentation (architecture, DB schema, API endpoints, data flows) and instructions to test the project are in [`DOCS.md`](./DOCS.md).