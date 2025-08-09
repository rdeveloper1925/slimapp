# Docker Setup Instructions for Slim PHP + React App

## 📁 Project Structure

Organize your project with this directory structure:

```
your-project/
├── docker-compose.yml
├── .dockerignore
├── backend/
│   ├── Dockerfile
│   ├── apache-config.conf
│   └── php.ini
├── frontend/
│   └── Dockerfile
├── nginx/
│   ├── nginx.conf
│   └── frontend.conf
├── slimappfront/          # Your existing React app
│   ├── package.json
│   ├── src/
│   └── ...
├── vendor/                # Your existing Slim PHP files
├── composer.json
├── public/
│   └── index.php
└── ...                   # Other Slim PHP files
```

## 🚀 Quick Start

### Step 1: Create Directory Structure
Create the folders and place the configuration files in their respective directories.

### Step 2: Update React API Calls
Update your React app's API calls to use the environment variable:

```javascript
const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000';

// Example usage
fetch(`${API_URL}/api/endpoint`)
  .then(response => response.json())
  .then(data => console.log(data));
```

### Step 3: Build and Start
Build and start the containers:

```bash
docker-compose up --build
```

## 🌐 Access Points

| Service | URL | Description |
|---------|-----|-------------|
| **React Frontend** | http://localhost:3000 | Development server with hot-reload |
| **PHP Backend** | http://localhost:8000 | Slim API endpoints |
| **Nginx Proxy** | http://localhost:80 | Optional unified access point |

## 🔧 Development vs Production

### Development Mode (Default)
- ✅ React runs with hot-reload
- ✅ PHP has error reporting enabled
- ✅ Volumes mounted for live code changes
- ✅ Source maps enabled

### Production Mode
Create a `docker-compose.prod.yml` file:

```yaml
version: '3.8'
services:
  frontend:
    build:
      context: ./slimappfront
      dockerfile: ../frontend/Dockerfile
      target: production
    ports:
      - "80:80"
  
  backend:
    build: 
      context: .
      dockerfile: backend/Dockerfile
    ports:
      - "8000:80"
    environment:
      - PHP_ENV=production
```

Run production mode:
```bash
docker-compose -f docker-compose.prod.yml up --build
```

## 📋 Common Commands

```bash
# Start all services in detached mode
docker-compose up -d

# Start with rebuild
docker-compose up --build

# View logs for all services
docker-compose logs -f

# View logs for specific service
docker-compose logs -f backend
docker-compose logs -f frontend

# Stop all services
docker-compose down

# Stop and remove volumes
docker-compose down -v

# Access container shell
docker exec -it slim-backend bash
docker exec -it react-frontend sh

# Restart specific service
docker-compose restart backend
```

## 🌍 Environment Variables

Create a `.env` file in your project root:

```env
# Backend Configuration
PHP_ENV=development
DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_username
DB_PASS=your_password

# Frontend Configuration
REACT_APP_API_URL=http://localhost:8000
REACT_APP_ENV=development
CHOKIDAR_USEPOLLING=true

# Optional: Database (if using Docker database)
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=your_database
MYSQL_USER=your_username
MYSQL_PASSWORD=your_password
```

## 🔍 Troubleshooting

### Common Issues

**Port conflicts:**
```bash
# Check what's running on ports
lsof -i :3000
lsof -i :8000

# Change ports in docker-compose.yml if needed
ports:
  - "3001:3000"  # External:Internal
```

**Permission issues:**
```bash
# Fix ownership
sudo chown -R $USER:$
