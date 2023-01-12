# SSO Login Package

### Installation
1. Run composer command to install the package
```bash
composer require icrewsystems/sso-system
```
2. After installing , add the env variables in the .env file
```
SSO_URL=
HOMEPAGE_ROUTE=
```
3. Now add the login button component in the login page of the application
```
<x-sso::login-button />
```
4. If the about component is not working, try publishing the components
```
php artisan vendor:publish --tag="sso-login-component"
```