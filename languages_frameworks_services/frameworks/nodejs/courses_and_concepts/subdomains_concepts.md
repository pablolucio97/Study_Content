# Subdomains concepts

A subdomain is the set of divisions of the domain of the our system. Generally subdomains are
classified on three different types:

### Core modules (fundamental for the system run)

Examples:

- Buy
- Catalog
- Delivery
- Billing

### Supporting (supports the core modules)

Examples:

- Deposit


### Generic (is optional, if removed, the system keep running)

Examples:

- Notifications
- Deals

## General Tips

- Which core must be independent. If you remove a core, an another one must continue working correctly.
- Maybe you can use third API's to deal with Generic Cors.