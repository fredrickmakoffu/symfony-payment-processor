<?php

namespace App\Command;

use App\Dto\Requests\PaymentRequest;
use App\Exceptions\ValidationException;
use App\Services\Payments\AciPaymentGateway;
use App\Services\Payments\Shift4PaymentGateway;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Services\Validations\PaymentValidationService;

#[AsCommand(
    name: 'app:process-payment',
    description: 'Add a short description for your command',
)]

class PaymentGatewayCommand extends Command
{
	public function __construct(
		private PaymentValidationService $paymentValidation,
		private AciPaymentGateway $aciPaymentService,
		private Shift4PaymentGateway $shift4PaymentService
	)
	{
	  parent::__construct();
	}

  protected function configure(): void
  {
    $this
      ->addArgument('system', InputArgument::REQUIRED, 'The payment system (aci|shift4)')
      ->addArgument('amount', InputArgument::REQUIRED, 'The payment amount')
      ->addArgument('currency', InputArgument::REQUIRED, 'The payment currency')
      ->addArgument('cardNumber', InputArgument::REQUIRED, 'The card number')
      ->addArgument('cardExpYear', InputArgument::REQUIRED, 'The card expiration year')
      ->addArgument('cardExpMonth', InputArgument::REQUIRED, 'The card expiration month')
      ->addArgument('cardCvv', InputArgument::REQUIRED, 'The card CVV');
    ;
  }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

       	// Get the payment data from the request
       	$payment_data = $input->getArguments();

        	// Validate the PaymentRequest DTO
        $errors = $this->paymentValidation->handle($payment_data);

        // If there are validation errors, throw an exception
        if (count($errors) > 0) throw new ValidationException($errors);

        $request = $this->paymentValidation->getValidatedDto();

				// Process the payment
			 	match ($payment_data['system']) {
					'aci' => $this->aciPaymentService->process($request),
					'shift4' => $this->shift4PaymentService->process($request),
					default => throw new \Exception('Given payment system not recognized')
				};

				// return success
				$io->success('Payment processed successfully.');

        return Command::SUCCESS;
    }
}
