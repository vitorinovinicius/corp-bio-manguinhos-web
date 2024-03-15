<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 16/11/2017
     * Time: 15:40
     */

    namespace App\Services;


    use App\Repositories\AddressRepository;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Support\Facades\Auth;

    class AddressService
    {
        /**
         * @var AddressRepository
         */
        private $addressRepository;

        /**
         * AddressService constructor.
         * @param AddressRepository $addressRepository
         */
        public function __construct(AddressRepository $addressRepository)
        {
            $this->addressRepository = $addressRepository;
        }

        public function saveAddress($address, $lat, $lng)
        {

            $data['address'] = $address;
            $data['lat'] = $lat;
            $data['lng'] = $lng;
            $this->addressRepository->create($data);
        }

        public function getByAddress($address)
        {
            return $this->addressRepository->findWhere(["address" => $address])->first();
        }
    }
