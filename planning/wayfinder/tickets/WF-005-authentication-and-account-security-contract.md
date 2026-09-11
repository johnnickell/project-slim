# Authentication and Account Security Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony authentication contract
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-003, WF-004

## Question

What production-grade browser authentication and account-security contract should Slim place around Fight
AccessControl's application capabilities?

## Must decide

- Define asymmetric access-token issuance and verification, claims, key-ring and rotation behavior, and clock policy.
- Define rotating refresh-session cookies, reuse detection, family revocation, expiry, device/session visibility, and
  server-side authoritative checks.
- Define SPA startup restoration, token storage boundaries, refresh serialization, expiry races, and failure recovery.
- Settle cookie attributes, CSRF defense, allowed-origin policy, CORS behavior, and request credential rules.
- Settle throttling dimensions and responses for authentication, recovery, invitation, and credential-sensitive paths.
- Map invitation, activation, password and credential lifecycle, recovery, lock or disable behavior, logout, logout-all,
  and administrator revocation.
- Identify audit events and privacy-safe error behavior for every security-sensitive transition.
- Keep short-lived access tokens only in client memory and refresh credentials only in Secure, HttpOnly cookies;
  rotate refresh credentials, detect reuse, reject expired/revoked/replayed/concurrent losers, and protect every
  cookie-backed operation with CSRF/Origin defenses.
- Rate-limit authentication and recovery by appropriate account/source dimensions, keep responses enumeration-safe,
  and prohibit credentials, bearer tokens, secrets, or raw sensitive request material in logs.

## Resolution boundary

This ticket settles the security model and browser session lifecycle. It does not implement cryptography, choose
undocumented package internals, finalize operation paths, or authorize public self-registration. Algorithms, claims,
lifetimes, cookie details, rate limits, and credential parameters remain fog until closure.

## Resolution

Open.
