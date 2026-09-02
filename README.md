# RadService – Fahrradwerkstatt-Bestellsystem

Team-Projekt für EWA. Läuft komplett über Docker (PHP + Apache + MariaDB + phpMyAdmin) — jeder im Team bekommt beim Start automatisch dieselbe Datenbankstruktur und dieselben Testdaten.

## Voraussetzungen

- **Docker Desktop** installiert und gestartet ([docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop/))
- **Git** installiert

Prüfen, ob alles bereit ist:
```bash
docker --version
docker compose version
docker info
```
`docker info` muss eine lange Ausgabe zeigen (nicht "Cannot connect..."). Falls doch, Docker Desktop öffnen und warten, bis in der Menüleiste "Docker Desktop is running" steht.

## Setup — einmalig pro Person

1. **Repository klonen:**
   ```bash
   git clone <REPO-URL>
   cd radservice
   ```

2. **Container bauen und starten:**
   ```bash
   docker compose up -d --build
   ```
   Beim ersten Mal dauert das 1–3 Minuten (Images laden, PHP-Container bauen, Datenbank initialisieren).

3. **Prüfen, ob alles läuft:**
   ```bash
   docker compose ps
   ```
   Erwartet: `web`, `db`, `phpmyadmin` jeweils mit Status `running`/`Up`.

4. **Im Browser öffnen:**
   - Projekt: [http://localhost:8080](http://localhost:8080)
   - phpMyAdmin: [http://localhost:8081](http://localhost:8081) (Login: `public` / `public`, für Root-Rechte: `root` / `ganzGeheim`)

Fertig — jeder hat jetzt lokal eine identische Datenbank mit Schema + Testdaten, ohne manuell etwas in phpMyAdmin einzurichten.

## Projektstruktur

```
radservice/
├── Dockerfile                  <- PHP 8.2 + Apache + mysqli-Extension
├── docker-compose.yml          <- definiert web / db / phpmyadmin
├── mariadb.setup/
│   ├── 01-RadService_Database.sql          <- Tabellen (CREATE TABLE)
│   └── 02-RadService_Database_Entries.sql  <- Testdaten (INSERT INTO)
├── App/
│   ├── Controller/
│   ├── Core/
│   ├── Model/
│   └── View/
│       └── partials/
├── assets/
│   ├── css/
│   └── js/
├── index.php
└── README.md
```

## Datenbank-Zugangsdaten (aus PHP, z.B. in `App/Core/BaseModel.php`)

```php
$conn = new mysqli('db', 'public', 'public', 'radservice');
```

**Wichtig:** Als Host `db` verwenden (= Service-Name aus der `docker-compose.yml`), **nicht** `localhost` — die Container sprechen intern über den Docker-eigenen Netzwerknamen miteinander.

## Alltägliche Befehle

| Befehl | Wirkung |
|---|---|
| `docker compose up -d` | Container starten (ohne neu zu bauen) |
| `docker compose down` | Container stoppen |
| `docker compose logs web` | Logs vom PHP/Apache-Container ansehen |
| `docker compose logs db` | Logs von MariaDB ansehen |
| `docker compose down -v && docker compose up -d --build` | **Kompletter DB-Reset** — löscht alle Daten und liest die `.sql`-Dateien neu ein |

## Workflow bei Schema-Änderungen (neue Tabelle/Spalte etc.)

1. Wer die Änderung macht: `mariadb.setup/01-RadService_Database.sql` (und ggf. `02-...Entries.sql`) anpassen, committen, pushen.
2. Alle anderen im Team:
   ```bash
   git pull
   docker compose down -v
   docker compose up -d --build
   ```
   Das `-v` löscht das alte Datenbank-Volume — **nur so** werden die `.sql`-Dateien erneut eingelesen, weil MariaDB sie sonst nur beim allerersten Start eines Volumes ausführt.

⚠️ Das löscht alle lokal eingetragenen Testdaten (eigene Bestellungen etc.) — ist aber gewollt, damit alle wieder denselben Stand haben.

## Troubleshooting

| Problem | Lösung |
|---|---|
| `no configuration file provided: not found` | Du bist nicht im Projektordner — `cd radservice` und `ls docker-compose.yml` prüfen |
| `unable to get image ... failed to connect to the docker API` | Docker Desktop läuft nicht — App öffnen und warten, bis "running" |
| Port 8080/8081 schon belegt | In `docker-compose.yml` z.B. auf `"8090:80"` ändern |
| `Call to undefined function mysqli_connect()` | Mit `docker compose up -d --build` (nicht ohne `--build`) neu bauen |
| DB-Verbindung schlägt direkt nach dem Start fehl | MariaDB braucht beim ersten Start etwas länger — kurz warten, Seite neu laden |
| Änderungen an `.sql`-Dateien wirken nicht | Volume ist schon initialisiert → `docker compose down -v && docker compose up -d --build` |
| "Access denied for user" | Zugangsdaten in `docker-compose.yml` und PHP-Code müssen exakt übereinstimmen (`public`/`public`) |

## Team-weit erreichbar machen (temporär, z.B. für gemeinsames Testen)

Wer gerade hostet, kann seine lokale Instanz per Cloudflare Tunnel kurzzeitig im Internet freigeben:

```bash
cloudflared tunnel --url http://localhost:8080 2>&1 | grep trycloudflare.com
```

Liefert eine `https://....trycloudflare.com`-URL, die alle im Team aufrufen können, solange der Host-Rechner + Docker laufen. Die Datenbank selbst bleibt dabei intern im Docker-Netzwerk und wird nicht öffentlich exponiert.
