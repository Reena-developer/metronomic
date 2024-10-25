# metronomic

## Requirements

- PHP >= 8.0
- Composer
- Laravel 11
- MySQL

1. **Clone the Repository:**

   ```bash
   git clone <repository-url>
   cd metronomic
   ```

2. **Install Dependencies:**

   ```bash
   composer install
   ```

3. **Set Up Environment Variables:**

   Copy the `.env.example` file to `.env` and configure it:

   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key:**

   ```bash
   php artisan key:generate
   ```

5. **Run Migrations:**

   ```bash
   php artisan migrate
   ```

6. **Run Seeders:**

   ```bash
   php artisan db:seed
   ```

7. **Generate Swagger Documentation:**

   ```bash
   php artisan l5-swagger:generate
   ```

You can access the API documentation at: [http://localhost/metronomic/public/api/documentation](http://localhost/metronomic/public/api/documentation)

To check the command, run:

```bash
php artisan meal-plan:get
```
