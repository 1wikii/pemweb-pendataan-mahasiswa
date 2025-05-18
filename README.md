# Student Data Management System

## 📋 Overview

This repository contains the source code for a student data management system, allowing users to register, login, and manage student records through a web interface.

## 🛠️ Tech Stack

- **Frontend:** <a href="https://developer.mozilla.org/en-US/docs/Web/HTML" style="cursor: pointer;">![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)</a> <a href="https://developer.mozilla.org/en-US/docs/Web/CSS" style="cursor: pointer;">![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)</a> <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" style="cursor: pointer;">![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)</a> <a href="https://jquery.com/" style="cursor: pointer;">![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=flat&logo=jquery&logoColor=white)</a>
- **Backend:** <a href="https://www.php.net/" style="cursor: pointer;">![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)</a>
- **Styling:** <a href="https://getbootstrap.com/" style="cursor: pointer;">![Bootstrap 5](https://img.shields.io/badge/Bootstrap-563D7C?style=flat&logo=bootstrap&logoColor=white)</a>
- **Database:** <a href="https://www.mysql.com/" style="cursor: pointer;">![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)</a>
- **Version Control:** <a href="https://git-scm.com/" style="cursor: pointer;">![Git](https://img.shields.io/badge/Git-F05032?style=flat&logo=git&logoColor=white)</a>

## 🔧 Installation & Setup

1. Clone the repository
   ```
   git clone https://github.com/1wikii/pemweb-pendataan-mahasiswa.git
   ```
2. Navigate to project directory
   ```
   cd pemweb-pendataan-mahasiswa
   ```
3. Set up your database

   ```
   $ mysql -u root -p

   mysql> CREATE DATABASE data_mahasiswa;
   ```

4. Configure database connection in `config/database.php`
5. Run on a PHP server
   ```
   php -S localhost:8000
   ```

## 📁 Project Structure

```
pemweb-pendataan-mahasiswa/
├── assets/
├── config/
├── css/
├── fonts/
├── middleware/
├── objects/
├── views/
└── ...
```

## 📷 Screenshots

<div align="center" style="display: flex; flex-direction: column; gap: 20px; justify-content: center; align-items: center;">
   <img   style="border-radius: 10px;" src="assets/login.png" width="400" />
   <img style="border-radius: 10px;" src="assets/dashboard.png" width="600" />
</div>

<!-- ## 🔗 Live Demo

[View the live website](https://your-demo-url.com) -->

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
