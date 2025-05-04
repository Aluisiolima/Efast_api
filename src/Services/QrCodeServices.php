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
            private readonly QrCodeModel $qrcodeModel,
            private readonly JWToken $jwtoken
        ){
            parent::__construct($jwtoken);
        }

        public function qrcode(int $id, mixed $auth): array | ResultInterface
        {
            try{
                $token = $this->verificaToken($auth);
                $id_empresa = $this->qrcodeModel->qrcode($id);

                $qrcode = $this->generateQrcode((int) $id_empresa);
                return  $qrcode;
            }catch(Exception $e){
                return ["error" => $e->getMessage()];
            }catch(PDOException $e){
                return ["error" => $e->getMessage()];
            }
        }
        
        //TODO: melhorar a legibilidade do qrcode
        public function generateQrcode(int $id): ResultInterface
        {
            // Cria o objeto QrCode com todos os parâmetros necessários
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

            // Instancia o writer de PNG e gera o resultado
            $writer = new PngWriter(); 
	        $logo = new Logo("src/asset/eFast-menu-black.png",150);

            $result = $writer->write(qrCode: $qrCode, logo: $logo);

            return $result;

        }
    }