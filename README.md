# Symfony Payment Processor

This project is a Symfony-based payment processing system that integrates with multiple payment processors such as ACI and Shift4. The system is designed to be modular, allowing for easy addition of new payment processors and ensuring that all requests are validated and processed correctly.

## Table of Contents
- [Tech Stack](#tech-stack)
- [Setup and Installation](#setup-and-installation)
- [Docker Configuration](#docker-configuration)
- [Routing](#routing)
- [Validation](#validation)
- [Payment Processing](#payment-processing)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)

## Tech Stack
- **PHP**: Version 8.0
- **Symfony**: Version 6.4
- **Docker**: For containerization
- **NGINX**: As the web server
- **Pest**: For testing

## Setup and Installation

### Step 1: Clone the Project
-------------------------

Clone your project to the server using the following command:

`git@github.com:fredrickmakoffu/symfony-payment-processor.git`

You can then navigate to the project directory using the following command:

`cd symfony-payment-processor`

### Step 2: Set up your .env file

Create a .env.local file and set your environment variables:

`cp .env .env.local`

### Step 3: Install Dependencies
-------------------------------

Run composer install to install all the dependencies required for the project:

`composer install`

### Step 4: Start the Docker Containers
-----------------------------------

Start the Docker containers using the following command:

`docker-compose up -d`

The `-d` flag runs the containers in detached mode.

### Step 5: Install Composer Dependencies
----------------------

So that all third party libraries can work in your environment, you can can install them in your docker environment with this command:

`docker-compose exec app composer install`


### Step 6: Test to see if application is up and running
-----------------------------

Once the Docker containers are up and running, you can access the application at:

`http://localhost:8080`
