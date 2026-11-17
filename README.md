# Ngọc Rồng Online (NRO) — Extended Online Web Portal, Download Center & Billing Platform

[![PHP](https://img.shields.io/badge/PHP-7.4%2B%20%2F%208.x-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![AJAX](https://img.shields.io/badge/Frontend-AJAX%20%2F%20jQuery-F7DF1E?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![IIS & Apache](https://img.shields.io/badge/Deployment-IIS%20%26%20Apache-2496ED)](https://httpd.apache.org/)

> The enhanced production web portal, multi-client download center, and automated transaction billing gateway for **Ngọc Rồng Online (Dragon Boy)** private game servers.

---

## 1. System Architecture

```mermaid
flowchart TD
    subgraph Client["Player & Mobile Clients"]
        Home["Web Portal Homepage (index.php)"]
        Recharge["Card & ATM Recharge (napthe.php, napatm.php)"]
        DownloadCenter["Client Download Center (taive/)"]
        Leaderboard["Real-Time Power Rankings (bxh.php)"]
    end

    subgraph SecurityAudit["Security & Audit Logging"]
        IpFilter["IP Clone Guard (checkIPclone.php)"]
        AuditLog["Transaction File Audit (card.log)"]
        ProfanityGuard["Profanity Filtering (profanity.txt)"]
    end

    subgraph BackendCore["Portal Core Engine (PHP 8.x)"]
        Bootstrap["Bootstrap & Config (cauhinh.php, config.php, connect.php)"]
        CallbackEngine["Telco Callback Processor (callback.php)"]
        GoldBarExchange["Gold Bar Exchange Controller (doi_thoi_vang.php)"]
    end

    subgraph ExternalTelco["External Telco API"]
        TelcoGateway["Partner Charging Gateway (Viettel, Vina, Mobi)"]
    end

    subgraph Database["Persistence (MySQL)"]
        NroSql[("Game Database (nro.sql)")]
    end

    Client --> SecurityAudit
    SecurityAudit --> BackendCore
    Recharge -->|Card Serial & PIN| TelcoGateway
    TelcoGateway -->|Webhook Callback| CallbackEngine
    CallbackEngine --> AuditLog
    CallbackEngine --> NroSql
    BackendCore --> NroSql
    DownloadCenter --> Client
```

---

## 2. Key Modules & Enhancements

* **Cross-Server Production Deployment**:
  * Dual configuration support for Linux/Apache (`.htaccess`) and Windows Server IIS (`web.config`).
  * Direct database connection layer (`connect.php`, `cauhinh.php`) with connection pooling and failover.
* **Integrated Client Download Center (`taive/`)**:
  * Direct downloads for official and customized game clients across Android (`.apk`), PC (`.rar`), and iOS (`.ipa`).
* **Automated Telco Charging & Audit Log**:
  * Integrates with online telecom scratch card APIs with asynchronous webhook confirmation.
  * Writes structured audit logs (`card.log`) for all transaction attempts, errors, and successful redemptions to prevent fraud.
* **Comprehensive Community & Game Mechanics**:
  * Gold bar exchange (`doi_thoi_vang.php`, `goldbar_callback.php`).
  * Live leaderboards (`bxh.php`) for top power and clan achievements.
  * Giftcode redemption (`giftcode_mtv.php`, `danhsach_gift.php`) and social sharing event rewards (`su_kien_share.php`).
* **Bundled Database Schema (`nro.sql`)**:
  * Complete turnkey MySQL database backup ready for initial setup or migration.

---

## 3. Tech Stack

| Domain | Technology |
| :--- | :--- |
| **Backend** | PHP 7.4+ / 8.x |
| **Database** | MySQL / MariaDB (bundled with `nro.sql`) |
| **Frontend** | HTML5, CSS3, JavaScript, jQuery / AJAX |
| **Web Server** | Apache (`.htaccess`) and Microsoft IIS (`web.config`) |

---

## 4. Getting Started

### Prerequisites
- PHP 7.4+ with `curl`, `pdo_mysql`, `json`, `mbstring` extensions
- MySQL 5.7+ / MariaDB 10.4+
- Apache or IIS Web Server

### Installation
1. Clone the repository into your web root:
   ```bash
   git clone https://github.com/btoan2802/web_nro_online.git
   ```
2. Import the bundled database schema (if not using an existing game database):
   ```bash
   mysql -u root -p < nro.sql
   ```
3. Configure your database and payment gateway credentials:
   - Copy `cauhinh.example.php` to `cauhinh.php` (or edit `config.php` and `connect.php`).
4. Ensure write permissions on `card.log` for web server transaction logging:
   ```bash
   chmod 666 card.log
   ```
5. Open your browser and navigate to `http://localhost/web_nro_online`.

---

## 5. Author & License

- **Author**: Nguyễn Bảo Toàn ([@btoan2802](https://github.com/btoan2802))
- **License**: Educational / Proprietary
