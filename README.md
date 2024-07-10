# Symfony Blog

## Requirements

- Docker
- Docker Compose

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Dreameryyy/Symfony-blog.git
    cd Symfony-blog
    ```

2. Start Docker containers:
    ```bash
    docker-compose up -d --build
    ```

3. Wait untill the application is ready by checking the logs
    ```bash
    docker-compose logs -f 
    ```
    Application is ready when the message `NOTICE: ready to handle connections` will pop up

4. Access the application:
    Open your browser and navigate to `http://localhost:8080/blog`

## Usage

- Create a new blog post at `http://localhost:8080/blog/new`
- View the list of blog posts at `http://localhost:8080/blog`
- View blog post details and add comments at `http://localhost:8080/blog/{id}`
