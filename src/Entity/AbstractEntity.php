<?phpnamespace App\Entity;use Symfony\Component\Serializer\Encoder\JsonEncoder;use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;use Symfony\Component\Serializer\Serializer;/** * Class AbstractEntity * @package App\Entity */class AbstractEntity{	/**	 * @return array	 */	public function serializer(): array	{		$serializer  = $this->createSerializer();		$jsonContent = $serializer->serialize($this, 'json');		return json_decode($jsonContent, true);	}	/**	 * @param array $data	 *	 * @return AbstractEntity	 */	public function populate(array $data): AbstractEntity	{		$data       = json_encode($data);		$serializer = $this->createSerializer();		$entity = $serializer->deserialize($data, static::class, 'json');		return $entity;	}	/**	 * @return Serializer	 */	private function createSerializer(): Serializer	{		$encoders    = [new JsonEncoder()];		$normalizers = [new ObjectNormalizer()];		return new Serializer($normalizers, $encoders);	}}