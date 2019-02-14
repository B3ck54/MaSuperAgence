<?php
/**
 * Created by PhpStorm.
 * User: Utisateur
 * Date: 11/02/2019
 * Time: 16:40
 */
namespace App\Listener;

use App\Entity\Picture;
use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber {

    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    /**
     * ImageCacheSubscriber constructor.
     * @param CacheManager $cacheManager
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {

        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return[
            'preRemove',
            'preUpdate'
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args){
        $entity =$args->getEntity();
        if($entity instanceof Picture){ //remove lorqu'une photo est supprimée
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));


    }


    public function preUpdate(PreUpdateEventArgs $args){
        $entity =$args->getEntity();
        if($entity instanceof Picture){
            return;
        }

         if($entity ->getImageFile instanceof UploadedFile){
             $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }

    }



}