<h1>Easy admin az fields</h1>

<h2>Available fields</h2>
<ul>
    <li><a href="#crop-field">CropField</a></li>
</ul>


<h2 id="crop-field">CropField</h2>

<h3>Example usage in Controller</h3>
<pre>
    
    $photo = CropField::new('file')
        ->setDataTransformer(new CropDataTransformer())
        ->setCropperSettings(
            (new CropperSettingsDto())
                ->setAspectRatio(13 / 4)
                ->setZoomable(false)
                ->setScalable(false)
        );
</pre>

<h3>Example CropDataTransformer</h3>
<pre>   
    
    namespace App\DataTransformer;
    
    use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
    use EasyAdminAzFields\Dto\CropperValueDto;
    
    class CropDataTransformer implements CropDataTransformerInterface
    {
        public function transform(mixed $value): CropperValueDto
        {
            $dto = new CropperValueDto();
    
            if (!$value instanceof YourFileEntity) {
                return $dto;
            }
    
            return $dto
                ->setOldImage($value->getCurrentImagePath());
        }
    
        public function reverseTransform(mixed $value): ?YourFileEntity
        {
            if (!$value instanceof CropperValueDto) {
                return null;
            }
    
            if(!$value->getImage() && !$value->getOldImage()){
                return null;
            }
    
            if(!$value->getImage() && $value->getOldImage()){      
               // return old value
            }
    
            return (new YourFileEntity());
        }
    }
</pre>

