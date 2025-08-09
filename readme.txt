PROJECT STRUCTURE.
slimapp/
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