---

# **Laravel Practice Project**  

This repository is for practicing Laravel development, including authentication, route testing, and API interactions using Postman.  

## **📌 Project Setup**  

### **1️⃣ Install Laravel**  
If you haven't installed Laravel, create the project using:  
```sh
laravel new laravel-practice
```

### **2️⃣ Navigate to the Project Folder**  
```sh
cd laravel-practice
```

### **3️⃣ Install Dependencies**  
```sh
composer install
npm install && npm run build
```

### **4️⃣ Start Laravel Server**
```sh
php artisan serve
```
If you get an error like *"Failed to listen on 127.0.0.1:8000"*, update your `php.ini`:  
Change  
```ini
variables_order = "EGPCS"
```
to  
```ini
variables_order = "GPCS"
```

---

## **📌 Laravel Authentication Routes**  

### **Guest Routes (No Authentication Required)**
| Method | Route                  | Description                           |
|--------|-------------------------|---------------------------------------|
| `GET`  | `/register`             | Show user registration form          |
| `POST` | `/register`             | Register a new user                  |
| `GET`  | `/login`                | Show login form                      |
| `POST` | `/login`                | Log in a user                        |
| `GET`  | `/forgot-password`      | Show password reset request form     |
| `POST` | `/forgot-password`      | Send password reset link             |
| `GET`  | `/reset-password/{token}` | Show password reset form           |
| `POST` | `/reset-password`       | Reset the user's password            |

### **Authenticated Routes (Require Login)**
| Method | Route                     | Description                              |
|--------|----------------------------|------------------------------------------|
| `GET`  | `/dashboard`               | Show user dashboard                      |
| `POST` | `/logout`                  | Log out the current user                 |
| `GET`  | `/verify-email`            | Show email verification notice           |
| `GET`  | `/verify-email/{id}/{hash}` | Verify user email                        |
| `POST` | `/email/verification-notification` | Resend verification email       |
| `GET`  | `/confirm-password`        | Show confirm password form               |
| `POST` | `/confirm-password`        | Confirm user password                    |
| `PATCH`| `/settings/profile`        | Update user profile                      |

---

## **📌 Testing Routes in Postman**  

### **1️⃣ Test Guest Routes (No Authentication Required)**  
- **Register a new user**
  - **Method:** `POST`
  - **URL:** `http://127.0.0.1:8000/register`
  - **Body (JSON format):**
    ```json
    {
      "name": "John Doe",
      "email": "johndoe@example.com",
      "password": "password",
      "password_confirmation": "password"
    }
    ```
  
- **Log in**
  - **Method:** `POST`
  - **URL:** `http://127.0.0.1:8000/login`
  - **Body (JSON format):**
    ```json
    {
      "email": "johndoe@example.com",
      "password": "password"
    }
    ```

- **Request a password reset**
  - **Method:** `POST`
  - **URL:** `http://127.0.0.1:8000/forgot-password`
  - **Body (JSON format):**
    ```json
    {
      "email": "johndoe@example.com"
    }
    ```

---

### **2️⃣ Test Authenticated Routes (Requires Login)**  
**Step 1: Log In and Get Session Cookies**  
- Send a `POST` request to `/login`
- In Postman, go to the **Cookies** tab and copy the session cookies.

**Step 2: Use Authenticated Routes**  
- **Update Profile**
  - **Method:** `PATCH`
  - **URL:** `http://127.0.0.1:8000/settings/profile`
  - **Headers:**
    ```
    Accept: application/json
    Content-Type: application/json
    ```
  - **Body (JSON format):**
  ```json
    {
      "name": "John Doe Updated",
      "email": "johndoe@example.com"
    }
    ```

- **Log Out**
  - **Method:** `POST`
  - **URL:** `http://127.0.0.1:8000/logout`

---

## **📌 Handling CSRF Tokens in Postman**  
If you receive a **419 Page Expired** error, Laravel requires a CSRF token for `POST`, `PATCH`, and `DELETE` requests.

### **Option 1: Disable CSRF for Testing (Not Recommended in Production)**
In `VerifyCsrfToken.php`, add routes to the `$except` array:
```php
protected $except = [
    'login',
    'logout',
    'settings/profile',
    'register'
];
```

### **Option 2: Send CSRF Token in Postman**
1. **Get the Token**  
   - Open `http://127.0.0.1:8000/login` in a browser.
   - Inspect the page source and look for:
     ```html
     <meta name="csrf-token" content="your_token_here">
     ```
   - Copy the value.

2. **Include in Postman Requests**  
   - Add a **Header**:
     ```
     X-CSRF-TOKEN: your_token_here
     ```
   - Or include in the **Body**:
     ```json
     {
       "_token": "your_token_here",
       "name": "Updated Name"
     }
     ```

---

## **📌 Additional Notes**
- Laravel authentication is **session-based by default**, so **Postman must store cookies**.
- To use Laravel **API authentication**, consider using **Laravel Sanctum** or **Laravel Passport**.

---

## **📌 Contribution Guidelines**
1. Create a feature branch:  
   ```sh
   git checkout -b feature-branch
   ```
2. Commit changes:  
   ```sh
   git commit -m "Add new feature"
   ```
3. Push changes:  
   ```sh
   git push origin feature-branch
   ```
4. Open a **Pull Request**.

---

## **📌 License**
This project is licensed under the MIT License.  

---
