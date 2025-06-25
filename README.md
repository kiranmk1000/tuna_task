# EMI Processing Task - Laravel Project

1. **Clone the Repository**

    ```bash
    git clone https://github.com/kiranmk1000/tuna_task.git
    cd tuna_task
    ```

2. **Install PHP Dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js Dependencies**

    ```bash
    npm install
    ```

4. **Build Frontend Assets**

    ```bash
    npm run dev
    ```

5. **Set Up Environment File**

    ```bash
    cp .env.example .env
    ```

6. **Configure Database**

    - Edit the `.env` file and set your database credentials:
        ```
        DB_DATABASE=your_db_name
        DB_USERNAME=your_db_user
        DB_PASSWORD=your_db_password
        ```

7. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

8. **Run Migrations and Seeders**

    ```bash
    php artisan migrate --seed
    ```

9. **Serve the Application**
    ```bash
    php artisan serve
    ```
    Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.
