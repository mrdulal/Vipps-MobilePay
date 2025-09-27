---
name: Bug Report
about: Create a report to help us improve
title: '[BUG] '
labels: bug
assignees: ''

---

## 🐛 Bug Description
A clear and concise description of what the bug is.

## 🔄 To Reproduce
Steps to reproduce the behavior:
1. Configure with settings '...'
2. Call method '...'
3. With parameters '...'
4. See error

## ✅ Expected Behavior
A clear and concise description of what you expected to happen.

## 🖥️ Environment Information
- **PHP Version:** [e.g. 8.1.0]
- **Laravel Version:** [e.g. 10.15.0]
- **Package Version:** [e.g. 1.2.3]
- **Vipps Environment:** [test/production]
- **OS:** [e.g. Ubuntu 20.04]

## 📋 Configuration
```php
// Relevant configuration (remove sensitive data)
'vipps' => [
    'environment' => 'test',
    // ... other relevant config
]
```

## 📄 Code Example
```php
// Minimal code example that reproduces the issue
use Mrdulal\LaravelVipps\Facades\Vipps;

$payment = Vipps::ePayment()->create([
    // ... payment data
]);
```

## 🚨 Error Details
```
// Full error message and stack trace
```

## 📊 Logs
```
// Relevant log entries (remove sensitive data)
```

## 💭 Additional Context
Add any other context about the problem here.

## ✅ Checklist
- [ ] I have searched existing issues to ensure this is not a duplicate
- [ ] I have included all relevant environment information
- [ ] I have provided a minimal code example
- [ ] I have removed all sensitive information (API keys, secrets, etc.)
- [ ] I have tested with the latest version of the package