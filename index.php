<?php
abstract class Plantilla {

  protected string $dni;
  protected string $nombre;
  protected string $apellidos;
  protected int $anhoAlta;


  public function __construct (string $dni, string $nombre, string $apellidos, int $anhoAlta) {

    $this -> dni = $dni;
    $this -> nombre = $nombre;
    $this -> apellidos = $apellidos;
    $this -> anhoAlta = $anhoAlta;
  }

abstract public function calcularSueldo();

public function __toString(): string {
    return sprintf("DNI: %s<br>Nombre: %s<br>Apellidos: %s<br>Año de ingreso: %d<br>Sueldo: %d €",
      $this->dni,
      $this->nombre,
      $this->apellidos,
      $this->anhoAlta,
      $this->calcularSueldo()
    );
  }


}



class Fijo extends Plantilla {

  public function calcularSueldo() {
    $salarioBase = 1200;
    $antiguedad = date("Y") - $this->anhoAlta;

        if ($antiguedad >= 2 && $antiguedad <= 7) {
            $salarioBase *= 1.15;
        } else if ($antiguedad > 7) {
            $salarioBase *= 1.25;
        }

        return $salarioBase;
    }

    public function __toString(): string {
      $sueldo = $this->calcularSueldo();
      $antiguedad = date("Y") - $this->anhoAlta;
  
      return sprintf("%s <br> <strong>Fijo</strong> <br> Antigüedad: %d año(s) <br> Sueldo: %d €",
          parent::__toString(),
          $antiguedad,
          $sueldo
      );
  }


}


class Eventual extends Plantilla {
    
    protected $web = 800;
    protected $webMulti = 300;

    protected $numWebs;
    protected $numWebsMulti;
    
  
    public function __construct($dni, $nombre, $apellidos, $anhoAlta, $numWebs, $numWebsMulti) {
      parent::__construct($dni, $nombre, $apellidos, $anhoAlta);
      $this->numWebs = $numWebs;
      $this->numWebsMulti = $numWebsMulti;
      
    }
    

    public function calcularSueldo() {
      $sueldoWebs = $this->numWebs * $this->web;
      $sueldoMultilenguaje = $this->numWebsMulti * $this->webMulti;
      return $sueldoWebs + $sueldoMultilenguaje;
    }

    public function __toString(): string {
      $sueldo = $this->calcularSueldo();
      
      return sprintf("%s <br> <strong>Eventual</strong> <br>Numero de Webs: %d <br> Numero de Webs Multilenguaje: %d <br> Sueldo: %d €",
          parent::__toString(),
          $this->numWebs,
          $this->numWebsMulti,
          $sueldo,
      );
    }
}

$fijo = new Fijo ('22457234T', 'Juan', 'Perez', '2010');
$eventual = new Eventual ('8746583P', 'Maria', 'Gomez', '2023', 2, 1, 1, 1);

echo $fijo . "<br>";
echo $eventual;