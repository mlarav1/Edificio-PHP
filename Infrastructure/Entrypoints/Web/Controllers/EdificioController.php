<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/EdificioWebMapper.php';

require_once __DIR__ . '/../../../../Application/Ports/In/CreateEdificioUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateEdificioUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetEdificioByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllEdificiosUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteEdificioUseCase.php';

require_once __DIR__ . '/../../../../Application/Services/Dto/Queries/GetAllEdificiosQuery.php';

final class EdificioController
{
    private CreateEdificioUseCase $createEdificioUseCase;
    private UpdateEdificioUseCase $updateEdificioUseCase;
    private GetEdificioByIdUseCase $getEdificioByIdUseCase;
    private GetAllEdificiosUseCase $getAllEdificiosUseCase;
    private DeleteEdificioUseCase $deleteEdificioUseCase;
    private EdificioWebMapper $mapper;

    public function __construct(
        CreateEdificioUseCase $createEdificioUseCase,
        UpdateEdificioUseCase $updateEdificioUseCase,
        GetEdificioByIdUseCase $getEdificioByIdUseCase,
        GetAllEdificiosUseCase $getAllEdificiosUseCase,
        DeleteEdificioUseCase $deleteEdificioUseCase,
        EdificioWebMapper $mapper
    ) {
        $this->createEdificioUseCase = $createEdificioUseCase;
        $this->updateEdificioUseCase = $updateEdificioUseCase;
        $this->getEdificioByIdUseCase = $getEdificioByIdUseCase;
        $this->getAllEdificiosUseCase = $getAllEdificiosUseCase;
        $this->deleteEdificioUseCase = $deleteEdificioUseCase;
        $this->mapper = $mapper;
    }

    /**
     * @return EdificioResponse[]
     */
    public function index(): array
    {
        $edificios = $this->getAllEdificiosUseCase->execute(new GetAllEdificiosQuery());

        return $this->mapper->fromModelsToResponses($edificios);
    }

    public function show(string $id): EdificioResponse
    {
        $query = $this->mapper->fromIdToGetByIdQuery($id);
        $edificio = $this->getEdificioByIdUseCase->execute($query);

        return $this->mapper->fromModelToResponse($edificio);
    }

    public function store(CreateEdificioWebRequest $request): EdificioResponse
    {
        $command = $this->mapper->fromCreateRequestToCommand($request);
        $edificio = $this->createEdificioUseCase->execute($command);

        return $this->mapper->fromModelToResponse($edificio);
    }

    public function update(UpdateEdificioWebRequest $request): EdificioResponse
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);
        $edificio = $this->updateEdificioUseCase->execute($command);

        return $this->mapper->fromModelToResponse($edificio);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteEdificioUseCase->execute($command);
    }
}