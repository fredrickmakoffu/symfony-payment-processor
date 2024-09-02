# Symfony Payment Processor

This project is a Symfony-based payment processing system that integrates with multiple payment processors such as ACI and Shift4. The system is designed to be modular, allowing for easy addition of new payment processors and ensuring that all requests are validated and processed correctly.

## Table of Contents
- [Tech Stack](#tech-stack)
- [Setup and Installation](#setup-and-installation)
- [API Endpoints](#api-endpoints)
- [Payment Processing](#payment-processing)
- [Testing](#testing)
- [Improvements](#improvements)

## Tech Stack
- **PHP**: Version 8.0
- **Symfony**: Version 6.4
- **Docker**: For containerization
- **NGINX**: As the web server
- **Pest**: For testing

## Setup and Installation

### Step 1: Clone the Project

Clone your project to the server using the following command:

`git@github.com:fredrickmakoffu/symfony-payment-processor.git`

You can then navigate to the project directory using the following command:

`cd symfony-payment-processor`

### Step 2: Set up your .env file

Create a .env file from the .env.example file in the project. You should set the necessary Shift4 and ACI credentials in the .env file.

This command will create a new .env file from the .env.example file:
`cp .env.example .env`

### Step 3: Install Dependencies

Run composer install to install all the dependencies required for the project:

`composer install`

### Step 4: Start the Docker Containers

Start the Docker containers using the following command:

`docker-compose up -d`

The `-d` flag runs the containers in detached mode.

### Step 5: Install Composer Dependencies

So that all third party libraries can work in your environment, you can can install them in your docker environment with this command:

`docker-compose exec app composer install`


### Step 6: Test to see if application is up and running

Once the Docker containers are up and running, you can access the application at:

`http://localhost:8080`

## API Endpoints

The following are the API endpoints available in the system:

- **POST /app/example/{payment_system}**:
	This endpoint is used to process payments. It accepts the following parameters:
	```
		- `amount`: The amount to be paid
		- `currency`: The currency to be used for the payment
		- `cardNumber`: The card number to be used for the payment
		- `cardExpYear`: The expiry year of the card
		- `cardExpMonth`: The expiry month of the card
		- `cardCvv`: The CVV of the card
	```

	You can set the payment system to either `shift4` or `aci` depending on the payment processor you want to use.

	You can also set these are additional headers to your request:
		- `Content-Type: application/json`
		- `Accept: application/json`


	The different payment processors require different card numbers that are already registered in their systems. Use this JSON example when testing with ACI:
	```json
	{
	  "currency": "EUR",
	  "cardNumber": "4200000000000000",
	  "cardExpYear": "2034",
	  "cardExpMonth": "05",
	  "cardCvv": "123",
	  "amount": "92.00"
	}
	```

	Use this JSON example when testing with Shift4:
	```json
	{
	  "currency": "USD",
	  "cardNumber": "card_TvVDIl7qipdWOCRC0xXRiF0K",
	  "cardExpYear": "2034",
	  "cardExpMonth": "05",
	  "cardCvv": "123",
	  "amount": "92.00"
	}
	```
## Payment Processing (description)

This is a quick overview of how the payment processing system works.

1. The client sends a POST request to the `/app/example/{payment_system}` endpoint with the payment details.

2. The request is routed to an Argument Resolver which validates the request and ensures that all the required parameters are present.

3. The request is then routed to the `PaymentController` which routes the request to the appropriate payment processor service, depending on the `payment_system` parameter.

4. The payment processor service then processes the payment and returns a response to the controller, formatted as a PaymentResponse object.

5. The controller then returns the response to the client.

The same process is largely repeated when you make a payment through the PaymentGatewayCommand. The only difference is that the command is run from the command line and not through an HTTP request.

1. The client runs the command `php bin/console app:process-payment {payment_system} {amount} {currency} {cardNumber} {cardExpYear} {cardExpMonth} {cardCvv}` with the payment details.

2. We validate the request and ensure that all the required parameters are present and in the format we require

3. We process the payment	and return a response to the client.



``
php bin/console app:process-payment shift4 92.00 USD 4200000000000000 2034 05 123
``
## Testing

To run the tests for the application, you can use the following command:

`docker-compose exec app ./vendor/bin/pest`

This will run all the tests in the application.

## Improvements

These are some features I would love to build in the project that are not yet implemented:

- **IOC**: Implement an Inversion of Control container to manage dependencies in the application. This should allow for two immediate project improvements:
	- We could create an argument resolver that selects the payment gateway type (aci|shift4) and injects the corresponding PaymentGatewayInterface into the controller alongside the PaymentRequest. This results in cleaner, more maintainable code.
	- We could use the IOC container to mock the payment gateway services in our tests. This would allow us to test the controller without actually making requests to the payment gateway services.

- **Storing Data in a Database**:
	- We could store payment data in a database to allow for easier tracking and management of payments. This would also allow us to implement features such as refunds and payment history.
	- We could also log any requests and responses to the payment gateway services in the database. This would allow us to track any issues that may arise during payment processing.
