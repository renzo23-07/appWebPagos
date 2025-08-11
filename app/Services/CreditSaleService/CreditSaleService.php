<?php
namespace App\Services\CreditSaleService;

use App\Repositories\CreditSaleRepository\Contracts\ICreditSaleRepository;
use App\Services\CreditSaleService\Contracts\ICreditSaleService;

class CreditSaleService implements ICreditSaleService
{
    protected $creditSaleRepository;
    public function __construct(ICreditSaleRepository $creditSaleRepository)
    {
        $this->creditSaleRepository = $creditSaleRepository;
    }

    public function show(string $id)
    {
        return $this->creditSaleRepository->show($id);
    }
}


?>