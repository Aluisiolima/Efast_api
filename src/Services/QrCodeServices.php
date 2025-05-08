<?php 
    namespace App\Services;

    use Exception;
    use PDOException;
    use App\Http\JWToken;
    use App\Model\QrCodeModel;
    use Endroid\QrCode\Color\Color;                                       
    use Endroid\QrCode\Encoding\Encoding;                                  
    use Endroid\QrCode\ErrorCorrectionLevel;                              
    use Endroid\QrCode\QrCode;                                             
    use Endroid\QrCode\RoundBlockSizeMode;                                 
    use Endroid\QrCode\Writer\PngWriter;                                   
    use Endroid\QrCode\Logo\Logo;
    use Endroid\QrCode\Writer\Result\ResultInterface;

    class QrCodeServices extends ServicesBase
    {
        public function __construct(
            private readonly JWToken $jwtoken
        ){
            parent::__construct($jwtoken);
        }

        public function qrcode(mixed $auth): array | ResultInterface
        {
            try{
                $token = $this->verificaToken($auth);

                return $this->generateQrcode((int) $token->id_empresa);
            }catch(Exception $e){
                return ["error" => $e->getMessage()];
            }catch(PDOException $e){
                return ["error" => $e->getMessage()];
            }
        }
        
        public function generateQrcode(int $id): ResultInterface
        {
            $qrCode = new QrCode(
                data: "efastmenu.com/{$id}",
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            ); 

            $writer = new PngWriter(); 
	        $logo = new Logo("src/asset/eFast-menu-black.png",100);

            $result = $writer->write(qrCode: $qrCode, logo: $logo);

            return $result;

        }
    }