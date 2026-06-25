# HTML5 Boilerplate Project Proposal Guidelines

The `@h5bp` organization is dedicated to maintaining high-performance, secure, and accessible open-source tools utilized by millions of developers globally. 

We are actively looking for new open-source projects to join the organization. This document outlines some requirements for inclusion.  

---

## 📋 Pre-Requisites

Before submitting an inclusion proposal, ensure your project meets the following mandator requirements:

1. **Licensing:** The project must be explicitly licensed under the **MIT License** (or a fully permissive, legally compatible open-source license).
2. **Co-Maintenance Intent:** H5BP acts as an active repository steward, not an archive for abandoned code. Original authors must commit to co-maintaining the project or, under certain circumstances, provide comprehensive documentation for a structured transition.
3. **Tooling Baseline:** The repository must use modern, standardized ecosystem tooling (e.g., standard package management configs, linting parameters, and unified lockfiles).

---

## 🛠️ Technical & Architecture Pillars

Proposals are evaluated by organization maintainers against four core criteria:

* **Ecosystem Utility:** The project must solve a widespread, foundational web development bottleneck or offer utility relevant to modern frontend architecture. 
* **Performance Budget:** We prioritize lean engineering and optimized, end-user experience. 
* **Architectural Discipline:** Code must be structured for long-term maintenance. Clean modularity, strict typing standards (TypeScript preferred), and comprehensive automated test suites are highly valued. Real, useful documentation is required. We educate as much as we provide features and functionality.
* **Security:** The repository must follow a security standard that matches the ecosystem footprint. A nice piece of documentation that is published as flat HTML will not be held to the same standards as a utility that is intended to be ubiquitously ingested by tools like npm. 

---

## 🚀 The Proposal Process

If your project clears the thresholds above, please execute the following onboarding loop:

### 1. Submit an RFC (Request for Comments)
Open an issue in our meta repository using the title prefix `[Project Proposal] Your Project Name`. In the description, clearly outline:
* The core problem your project solves and its utility to the H5BP community.
* A link to the active repository.
* An overview of the project's dependency graph and test coverage.

### 2. Review & Community Window
Maintainers and the community will review the architecture, ask clarifying technical questions, and assess strategic and cultural fit.

### 3. Structured Migration
Upon approval, a maintainer will coordinate the native GitHub repository transfer. 
