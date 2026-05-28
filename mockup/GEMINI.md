# Stitch 360 Culture Performance Platform - Design Prototypes

This repository contains the design system and interactive UI prototypes for the **Stitch 360 Culture Performance Platform** (also known as **CendolBata**). The platform is designed to balance positive peer-to-peer appreciation with high-integrity corporate reporting.

## Project Overview

The project is a collection of high-fidelity, interactive prototypes. It serves as a visual and functional reference for the development of the platform, focusing on user experience, psychological safety, and corporate transparency.

**Note:** The design system has been migrated to use **Bootstrap 5** defaults for better consistency and familiar corporate aesthetics.

### Core Features

-   **Ethos & Recognition:** Documentation of the platform's brand identity, design system (Bootstrap-based), and core values.
-   **Feed Budaya (Culture Feed):** A centralized stream of cultural interactions and transaction history.
-   **Kirim Cendol (Appreciation):** A mechanism for peer-to-peer recognition using "Cendol" (mapped to Bootstrap `success`).
-   **Kirim Bata (Incident Reporting):** A confidential whistleblowing channel for reporting incidents (mapped to Bootstrap `danger`).

## Directory Structure

The project is organized by feature modules:

-   `design_stitch_360_culture_performance_platform/`: Main design assets.
    -   `ethos_recognition/`: Design system documentation (`DESIGN.md`).
    -   `feed_budaya_riwayat_transaksi/`: Prototypes for the culture feed and history.
    -   `kirim_bata_pelaporan_insiden/`: Prototypes for incident reporting.
    -   `kirim_cendol_apresiasi_budaya/`: Prototypes for peer appreciation.
    -   `stitch_360_culture_performance_platform/`: (Nested duplicate of the above structure).

## Key Files

-   **`DESIGN.md`**: The source of truth for the design system. It defines:
    -   **Brand Personality:** Professional, Transparent, and Balanced.
    -   **Framework:** Bootstrap 5.
    -   **Color Palette:** Standard Bootstrap semantic colors (`primary`, `success`, `danger`, etc.).
    -   **Typography:** Native System UI font stack.
    -   **Layout:** Bootstrap 12-column responsive grid.
-   **`code.html`**: Self-contained HTML files containing the UI prototypes.
-   **`screen.png`**: Static image references for the intended UI design.

## Usage

### Viewing Prototypes
To view the interactive prototypes, open any `code.html` file in a modern web browser. 
Example: `design_stitch_360_culture_performance_platform/feed_budaya_riwayat_transaksi/code.html`

### Development
The prototypes are intended to be built/maintained using:
-   **CSS Framework:** [Bootstrap 5](https://getbootstrap.com/).
-   **Icons:** [Material Symbols Outlined](https://fonts.google.com/icons).

## Design Conventions

-   **Component Logic:** 
    -   **Success (`.text-success`, `.btn-success`):** Positive interactions (Cendol).
    -   **Danger (`.text-danger`, `.btn-danger`):** Critical/Reporting interactions (Bata).
-   **Spacing:** Follows Bootstrap's standard spacing utilities (`m-1` to `m-5`).
-   **Responsive Design:** Utilizes Bootstrap's responsive breakpoints and grid classes.
