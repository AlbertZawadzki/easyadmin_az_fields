<h1>Easy admin az fields</h1>

<h2>Available fields</h2>
<ul>
    <li><a href="#crop-field">CropField</a></li>
</ul>

<h2 id="crop-field">CropField</h2>

<h3>Example CropDataTransformer</h3>
<pre>

    namespace App\DataTransformer;
    
    use App\Entity\File;
    use App\Interfaces\FileManagerInterface;
    use App\Service\TokenGenerator;
    use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
    use EasyAdminAzFields\Dto\CropperValueDto;
    use RuntimeException;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    
    class FileDataTransformer implements CropDataTransformerInterface
    {
        public function __construct(
            private readonly FileManagerInterface $fileManager
        )
        {
        }
    
        public function transform(mixed $value): CropperValueDto
        {
            $dto = new CropperValueDto();
    
            if (!$value instanceof File) {
                return $dto->setOldImage($value);
            }
    
            return $dto
                ->setOldImage($value->getUrl());
        }
    
        public function reverseTransform(mixed $value): ?string
        {
            if (!$value instanceof CropperValueDto) {
                return null;
            }
    
            if (!$value->getImage()) {
                return $value->getOldImage();
            }
    
            $tempPath = $value->getImage();
            $uploaded = new UploadedFile($tempPath, 'tempfile', null, null, true);
            $extension = $uploaded->guessExtension();
            // Your file name
            $randomFileName = "random" . rand();

            // Full path where you want to upload the file
            $uploadPath = "/{$randomFileName}.{$extension}";

            // Saves file
            $uploaded = $this->fileManager->save($uploadPath, $uploaded->getContent());
            if (!$uploaded) {
                throw new RuntimeException("Failed to upload the file");
            }
    
            // The image path which will be passed to entity
            // You can return whatever you want it will be set into your entity
            return $this->fileManager->getFullPath($uploadPath);
        }
    }
</pre>

<h3>Need more help how to use it?</h3>
<p>
    Need more data than just single field? Enjoy my form for entity "File"<br/>
    The entity has 3 fields: <code>name</code>, <code>alt</code> and <code>url</code>
</p>

<pre>

    namespace App\Form;

    use App\DataTransformer\FileDataTransformer;
    use App\Entity\File;
    use Doctrine\ORM\EntityManagerInterface;
    use EasyAdminAzFields\Dto\CropperSettingsDto;
    use EasyAdminAzFields\Form\CropType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\DataTransformerInterface;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\Form\FormEvent;
    use Symfony\Component\Form\FormEvents;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class FileForm extends AbstractType
    {
        public function __construct(
            private readonly EntityManagerInterface $em,
            private readonly FileDataTransformer    $fileDataTransformer,
        )
        {
        }
    
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Name',
                ])
                ->add('alt', TextType::class, [
                    'label' => 'Alt',
                    'required' => false,
                ])
                ->add('url', CropType::class, [
                    'label' => 'File',
                    CropType::OPTION_DATA_TRANSFORMER => $options[CropType::OPTION_DATA_TRANSFORMER],
                    CropType::OPTION_CROPPER_SETTINGS => $options[CropType::OPTION_CROPPER_SETTINGS],
                ])->addEventListener(
                    FormEvents::SUBMIT,
                    function (FormEvent $event) {
                        $data = $event->getData();
    
                        if (!$data instanceof File) {
                            return;
                        }
    
                        if ($data->getUrl()) {
                            return;
                        }
    
                        $event->setData(null);
                        $this->em->detach($data);
                    }
                );
        }
    
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'class' => File::class,
                'data_class' => File::class,
                'query_builder' => null,
                CropType::OPTION_CROPPER_SETTINGS => new CropperSettingsDto(),
                CropType::OPTION_DATA_TRANSFORMER => $this->fileDataTransformer,
            ])->setAllowedTypes(
                CropType::OPTION_CROPPER_SETTINGS,
                [
                    CropperSettingsDto::class
                ]
            )->setAllowedTypes(
                CropType::OPTION_DATA_TRANSFORMER,
                [
                    DataTransformerInterface::class
                ]
            );
        }
    }
</pre>
<h3>Field definition in CrudController</h4>
<pre>
    AssociationField::new('backgroundImage', "")
        ->setRequired(false)
        ->setFormType(FileForm::class)
        ->setFormTypeOption(
            CropType::OPTION_CROPPER_SETTINGS,
            new CropperSettingsDto()
                ->setAspectRatio(16 / 10)
        ),
</pre>