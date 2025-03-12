# **Laravel Practice Project**

This repository is for practicing Laravel development, including authentication, route testing, API interactions using Postman, and modular architecture using `nwidart/laravel-modules`.

## **📌 Project Setup**  
### **1️⃣ Install Laravel**  
If you haven't installed Laravel, create the project using:  
```sh
laravel new laravel-practice
```  
- Select **React Starter Kit** (`react`).  
- Choose **Laravel** as the authentication provider.  
- Set **Pest** as the testing framework.  
- Agree to run:  
  ```sh
  npm install && npm run build
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

### **4️⃣ Configure `nwidart/laravel-modules`**
To enable modular architecture, install `nwidart/laravel-modules`:
```sh
composer require nwidart/laravel-modules
```

#### **Publish the Package Configuration**
Run the following command to publish the package configuration file:
```sh
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

#### **Enable Merge Plugin for Composer**
To allow Laravel to merge module-specific `composer.json` files, add the following to `composer.json`:
```json
"extra": {
    "laravel": {
        "dont-discover": []
    },
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"
        ]
    }
}
```
Then, run:
```sh
composer update
```

### **5️⃣ Start Laravel Server**  
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

### **Option 1: Use Laravel's CSRF Endpoint (Recommended)**

1. Send a `GET` request to:
   ```sh
   http://127.0.0.1:8000/sanctum/csrf-cookie
   ```
2. Postman will store the CSRF token automatically for subsequent requests.

### **Option 2: Manually Send CSRF Token**

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
### **Option 3: Disable CSRF for Testing (Not Recommended in Production)**
In `VerifyCsrfToken.php`, add routes to the `$except` array:
```php
protected $except = [
    'login',
    'logout',
    'settings/profile',
    'register'
];
```

---

## **📌 Modular Architecture & Parent-Child Relationship**

### **Creating Modules**
To generate a module, use:
```sh
php artisan module:make Company
php artisan module:make Employee
```

### **Generating Models, Migrations, and Controllers**
```sh
php artisan module:make-model Company -m
php artisan module:make-model Employee -m
php artisan module:make-controller CompanyController
php artisan module:make-controller EmployeeController
```

### **Migration Files**
Update `2025_xx_xx_xxxxxx_create_companies_table.php`:
```php
Schema::create('companies', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('address')->nullable();
    $table->timestamps();
});
```

Update `2025_xx_xx_xxxxxx_create_employees_table.php`:
```php
Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('position');
    $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
    $table->timestamps();
});
```

Run the migrations:
```sh
php artisan migrate
```

### **Seeding Data for Testing**
Create a seeder:
```sh
php artisan module:make-seed EmployeesTableSeeder
```
Modify `EmployeesTableSeeder.php`:
```php
public function run()
{
    $company = \Modules\Company\Models\Company::create([
        'name' => 'Tech Corp',
        'address' => '123 Main Street'
    ]);

    for ($i = 1; $i <= 5; $i++) {
        $company->employees()->create([
            'name' => "Employee $i",
            'email' => "employee{$i}@example.com",
            'position' => 'Developer'
        ]);
    }
}
```
Run the seeder:
```sh
php artisan db:seed --class=Modules\\Employee\\Database\\Seeders\\EmployeesTableSeeder
```

### **Unit Testing the Relationship**
Create a test file:
```sh
php artisan make:test EmployeeTest --unit
```
Modify `EmployeeTest.php`:
```php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Employee\Models\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_employee()
    {
        $employee = Employee::create([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'position' => 'Developer',
            'company_id' => 1
        ]);

        $this->assertDatabaseHas('employees', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_retrieve_an_employee()
    {
        $employee = Employee::factory()->create();
        $found = Employee::find($employee->id);

        $this->assertNotNull($found);
        $this->assertEquals($employee->id, $found->id);
    }
}
```
Run the tests:
```sh
php artisan test --filter=EmployeeTest
```

---

## **📌 License**  
This project is licensed under the MIT License.

---

