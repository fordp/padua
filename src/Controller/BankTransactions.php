<?php

namespace App\Controller;

use App\Entity\BankTransaction;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FileUploadForm;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * @Route("/bank", name="bank_")
 */
class BankTransactions extends AbstractController
{
    /**
     * The main route for this application.
     * 
     * @Route("/", name="index")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        // This will determine if the transaction table will be displayed.
        $displayTransactions = false;
        // Array of transactions to be displayed.
        $transactions = array();

        $form = $this->createForm(FileUploadForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['upload_file']->getData();

            if ($file) {
                $logger->info("File exixts.");

                // Counter to keep track of rows.
                $rowNum = 0;
                if (($fh = fopen($file, "r")) !== false) {
                    $displayTransactions = true;

                    while (($row = fgetcsv($fh, 1000, ",")) !== false) {
                        $rowNum++;
                        if ($rowNum == 1) {
                            continue;
                        }

                        // Validate incoming values, and then save them if good.
                        try {
                            if (!is_string($row[1])) {
                                throw new Exception("Transaction Code is not a string.");
                            }
                            if (!is_numeric($row[2])) {
                                throw new Exception("Customer Number is not an integer.");
                            }
                            if (!is_string($row[3])) {
                                throw new Exception("Reference is not a string.");
                            }
                            if (!is_numeric($row[4])) {
                                throw new Exception("Amount is not Currency.");
                            }
                            $bankTransaction = new BankTransaction();
                            $bankTransaction->setDate(new DateTime($row[0]));
                            $bankTransaction->setTransactionCode($row[1]);
                            $bankTransaction->setCustomerNumber($row[2]);
                            $bankTransaction->setReference($row[3]);
                            $bankTransaction->setAmount($row[4]);

                            $transactions[] = $bankTransaction;
                        } catch (Exception $e) {
                            $logger->info("The transaction contained incorrect info. " . $e);
                            continue;
                        }
                    }

                    fclose($fh);
                } else {
                    // If we can't open the file, then notify someone.
                    $logger->error("Failed to open file '$file'.");
                }
            }
        }

        // If there are transactions, then sort them by date.
        if (count($transactions) > 0) {
            usort($transactions, function ($a, $b) {
                return strcmp($a->getDate()->format('U'), $b->getDate()->format('U'));
            });
        }

        return $this->render('bank/index.html.twig', [
            'form' => $form->createView(),
            'displayTransactions' => $displayTransactions,
            'transactions' => $transactions

        ]);
    }
}
