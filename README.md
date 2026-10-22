# GimList v2

A web-based game listing platform built with PHP and MySQL, designed to help users explore and interact with game-related content.

## Overview

GimList is a web application that organizes game information and provides features for users to interact with the platform. This version also includes Docker configuration to simplify application setup and deployment across different environments.

## Features

- **Game Listings** — Browse available games.
- **Categories** — Organize games by category.
- **User Accounts** — Support user account functionality.
- **Ratings and Comments** — Allow users to interact with game content.
- **Likes** — Support interactions with listed games.
- **Merchandise Section** — Browse available merchandise.
- **Docker Support** — Run the application and database using Docker Compose.

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP | Backend development |
| MySQL | Database management |
| HTML, CSS, JavaScript | Frontend development |
| Apache | Web server |
| Docker | Application containerization |
| Docker Compose | Application and database orchestration |

## Project Structure

```text
Gimlist-v2/
├── Dockerfile
├── compose.yml
├── gimlist.sql
├── config.php
└── ... application files
```

The project also contains the application's pages, assets, and other supporting files.

## Getting Started

### Prerequisites

Make sure you have installed:

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)

### 1. Clone the Repository

```bash
git clone https://github.com/sellyrest/Gimlist-v2.git
cd Gimlist-v2
```

### 2. Start the Application

Build the application image and start the application and database containers:

```bash
docker compose up --build
```

Wait for the containers to start.

### 3. Access the Application

Open your browser and visit:

```text
http://localhost:8000
```

### 4. Stop the Application

To stop the running containers, press `Ctrl + C` in the terminal, then run:

```bash
docker compose down
```

## Database Configuration

The project uses MySQL as its database. The `gimlist.sql` file is mounted into the MySQL initialization directory to initialize the database when the database container is created with an empty data directory.

The PHP application connects to the database through the Docker Compose service hostname:

```php
mysqli_connect("db", "root", "root", "gimlist");
```

**Note:** The hostname `db` refers to the database service inside the Docker Compose network. When running the application directly on your computer instead of inside Docker, the database connection settings may need to be adjusted.

For a fresh database initialization, existing database data may need to be removed or reset before recreating the container. Be careful: resetting database storage can delete existing data.

## Running with Docker

Docker Compose manages the application's services:

- **App service:** Builds and runs the PHP application with Apache.
- **DB service:** Runs MySQL and initializes the database using `gimlist.sql`.

The application is exposed on port `8000` on the host machine, while the database service uses port `3306`.

## Development Notes

- Ensure Docker Desktop is running before starting the containers.
- Check the container logs if the application or database fails to start:

  ```bash
  docker compose logs
  ```

- Database initialization scripts run automatically only when MySQL initializes a new data directory.
- For production use, configure credentials securely and avoid using the database root account for application access.

## Contributors

This project was developed collaboratively. Contributors worked on application features, database integration, and Docker configuration.

## License

No license has been specified for this repository yet.
