# BookStore Dev Notes

- To seed demo data: visit `/php/BookStore/admin/books.php` and create a few entries or run a seeder (to be added).
- Borrow/Return flows live in `models/borrow.php`, student pages under `student/`.
- Public shop pulls from `/php/BookStore/fetch_books.php`.

# To Extract New Update To Database:

** mysql -u root -p bookstore < 001_create_users_table.sql (depends on new updates) **

---

# Add New Updates To Databade

** Create a new file with the updates in ./database/migrations **

---
