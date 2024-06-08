# Contributions

Thank you for considering contributing to this project! We appreciate your time and effort in improving our codebase.

Here are some guidelines to help you get started:

## Getting Started

1. **Fork the repository**: Click the "Fork" button at the top right of this page to create a copy of this repository in
   your GitHub account.
2. **Clone your fork**: Clone your forked repository to your local machine using:

```sh
git clone https://github.com/your-username/your-fork.git
```

3. **Create a branch**: Create a new branch for your changes:

```sh
git checkout -b your-branch-name
```

## Making Changes

1. **Code changes**: Make your changes to the codebase. Ensure that your code follows the project's coding standards and
   passes all tests.
2. **Update documentation**: If your changes affect documentation, please update it accordingly.
3. **Update version in `composer.json`**: Whenever you make any updates to the code, please remember to update the
   version in the `composer.json` file under the `scripts` section. For example:

```json
{
  "scripts": {
    "package:version": "echo v1.10.3"
  }
}
```

Increment the version number appropriately following [Semantic Versioning](https://semver.org/spec/v2.0.0.html)
principles (e.g., **v1.10.2** to **v1.10.3**).

## Submitting Your Changes

1. **Commit your changes**: Commit your changes with a clear and descriptive message:

```sh
git commit -m "Description of your changes"
```

2. **Push to your fork**: Push your changes to your forked repository:

```sh
git push origin your-branch-name
```

3. **Create a pull request**: Open a pull request from your forked repository to the main repository. Provide a clear
   description of your changes and any relevant information.

## Code Review

- Your pull request will be reviewed by project maintainers. Please be responsive to any feedback or requested changes.
- Once your changes are approved, they will be merged into the main branch.

## Thank You!

We appreciate your contribution to the project. If you have any questions or need further assistance, please don't
hesitate to reach out.
