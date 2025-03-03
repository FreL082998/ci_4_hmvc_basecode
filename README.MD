# CodeIgniter 4 Docker Setup

## Author
Freddie Rick Labuanan

## Prerequisites
Ensure you have the following installed on your machine:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Project Structure
```
root
│── api/                   # CodeIgniter 4 source code
│── docker/
│   ├── php/               # PHP Docker configuration
│   │   ├── Dockerfile     # PHP-FPM Dockerfile
│   ├── nginx/             # Nginx configuration template
│   │   ├── default.conf.template
│   ├── mysql/             # MySQL initialization
│   │   ├── entrypoint.sh  # Dynamic MySQL user setup
│── docker-compose.yml     # Docker Compose configuration
│── .env                   # Environment variables
```

## Installation
1. Clone this repository and navigate to the project root.
2. Create a `.env` file based on `.env.example` and configure your environment variables.
3. Run the following command to build and start the services:
   ```sh
   docker-compose up --build -d
   ```

## Environment Variables
Set up your `.env` file with the following variables:
```ini
APP_NAME=ci4-app
API_PATH=api
API_PORT=8080
DB_CONNECTION=mysql
DB_VERSION=8.0
DB_DATABASE=ci4_db
DB_USERNAME=developer
DB_PASSWORD=Abc@12345
DB_ROOT_PASSWORD=root
DB_PORT=3306
```

## Usage
- Access the CodeIgniter application at: `http://localhost:${API_PORT}`
- Access MySQL inside the container:
  ```sh
  docker exec -it ${APP_NAME}-db mysql -u${DB_USERNAME} -p${DB_PASSWORD}
  ```

## Logs & Debugging
- View container logs:
  ```sh
  docker-compose logs -f
  ```
- Restart services:
  ```sh
  docker-compose down && docker-compose up --build -d
  ```

## License
This project is open-source and available under the [MIT License](LICENSE).

