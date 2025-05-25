# Version Increment Workflow Summary

## Trigger
- Runs when a PR from `next` branch is merged into `main` branch

## Workflow Logic

### 1. Version Source
- Reads current version from `next` branch `package.json` (source of truth)
- Example: If next branch has version `1.0.0`

### 2. Main Branch
- **NO CHANGES MADE TO MAIN BRANCH**
- Main branch files remain exactly as they were after the merge
- Main branch represents the "released" state

### 3. Next Branch Updates
- Increments the version (patch version +1)
- Updates both files in next branch:
  - `test-repo.php`: Plugin header, TEST_REPO_VERSION constant, class VERSION constant
  - `package.json`: NPM version field
- Example: Updates next branch from `1.0.0` to `1.0.1`

### 4. Release Creation
- Creates git tag for the current version (e.g., `v1.0.0`)
- Creates GitHub release for the current version
- Tag points to main branch (the released code)

## Version Flow Example

```
Before PR merge:
- next branch: 1.0.0 (in package.json)
- main branch: (whatever was there)

After workflow runs:
- main branch: UNCHANGED (represents released v1.0.0)
- next branch: 1.0.1 (ready for next development)
- Git tag: v1.0.0 (points to main branch)
- GitHub release: v1.0.0
```

## Key Benefits
- Main branch stays clean and represents exactly what was released
- Next branch is automatically prepared for the next development cycle
- Version source of truth is always the next branch package.json
- No risk of modifying released code in main branch 