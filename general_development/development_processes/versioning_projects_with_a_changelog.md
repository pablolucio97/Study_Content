# Versioning Projects with a Changelog

A **Changelog** is a `.md` file containing a chronological list of all meaningful changes made to your software. Maintaining a changelog is useful to provide a history of feature development for developers and end users.

---

## Types of Changes

Each version (tag) should document what was:

- **Added**: New features
- **Changed**: Modifications to existing functionality
- **Deprecated**: Features that will be removed in a future version
- **Removed**: Features removed in this version
- **Fixed**: Bug fixes or behavioral corrections
- **Security**: Security improvements

---

## General Tips

- There is no strict standard format. You can maintain a `changelog.md` to document your project.
- You can automate changelog generation via GitHub:
  - Go to your GitHub repo
  - Click **Releases** > **Draft a new release**
  - Set a tag (e.g., `1.5.4`) and click **Generate release notes**
- Use the date format `YYYY-MM-DD` (e.g., `2022-10-11`)
- Always keep a **[Unreleased]** section at the top as a roadmap for what's coming next

---

## Changelog Template Example

### Changelog

## 1.6.4 (2022-10-11)

### Added
- Faq screen. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/8aeb5423f24fc7017b3f57ef47ffe0466af10e4c)

### Changed
- Some colors on theme. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/8aeb5423f24fc7017b3f57ef47ffe0466af10e4c)

### Fixed
- Biometric authentication flow. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/ef770a904e5a86b45af614ebf06be77613ac3e2d)
- Edit password modal. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/ef770a904e5a86b45af614ebf06be77613ac3e2d)

## 1.5.3 (2022-10-07)

### Added
- Dark theme feature. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/ef770a904e5a86b45af614ebf06be77613ac3e2d)
- Generate strong password feature. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/ef770a904e5a86b45af614ebf06be77613ac3e2d)
- Export data feature. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/e464660b83c9758a351dedf2e16a7b60aeac30ea)
- Copy password feature. [Commit](https://github.com/Pablo-Silva-Dev/keepsave-mobile/commit/87ed03715860162e3f9310d41c7ffcc76273691f)
