<?php
class Dinero {
    public $familia;
    public $herencia;
    public $gobierno;
    public $salario;
    public $emprendimiento;
    public $parejaMin;
    public $parejaSum;
    public $hijos;
    public $regalos;
    public $deudas;
    public $pension;

    public function __construct($edad) {
        echo "Por favor, introduce los siguientes valores:\n";

        echo "Cuanto dinero te daria tu Familia al mes: ";
        $this->familia = trim(fgets(STDIN)) * 12;

        echo "Cuanto dinero de Herencia recibirias: ";
        $this->herencia = trim(fgets(STDIN));

        echo "Cuanto dinero te daria el Gobierno: ";
        $this->gobierno = trim(fgets(STDIN));

        $this->salario = 0;
        $this->emprendimiento = 0;
        $this->parejaMin = 0;
        $this->parejaSum = 0;
        $this->hijos = 0;
        $this->deudas = 0;
        $this->pension = 0;
        $this->regalos = 0;

        if ($edad >= 17){
            echo "cuanto dinero mensual recibes de Salario: ";
            $this->salario = (trim(fgets(STDIN))) * 12;

            echo "si tienes algun emprendimiento cuanto dinero generaria: ";
            $this->emprendimiento = trim(fgets(STDIN));
            
            echo "Tienes pareja? (si/no): ";
            $tienePareja = trim(fgets(STDIN));
            if ($tienePareja == 'si') {
                echo "cuanto dinero inviertes en tu Pareja: ";
                $this->parejaMin = trim(fgets(STDIN));

                echo "cuanto dinero invierte tu Pareja en ti: ";
                $this->parejaSum = trim(fgets(STDIN));
            }
        }

        if ($edad >= 30){
            echo "Tienes hijos? (si/no): ";
            $tieneHijos = trim(fgets(STDIN));
            if ($tieneHijos == 'si') {
                echo "si tienes hijos cuanto dinero invertirias en ellos al mes: ";
                $this->hijos = trim(fgets(STDIN))*12;
            }

            echo "que valor en Deudas tienes: ";
            $this->deudas = trim(fgets(STDIN));
        }

        
        echo "cuanto dinero gasta en Regalos: ";
        $this->regalos = trim(fgets(STDIN));

        if ($edad >= 68){
            echo "cuanto dinero recibe de pension mensualmente: ";
            $this->pension = trim(fgets(STDIN)) * 12;
        }

        
    }

    public function calcularTotal() {
        try {
            if (!is_numeric($this->familia) || !is_numeric($this->herencia) || !is_numeric($this->gobierno) || !is_numeric($this->salario) || !is_numeric($this->emprendimiento) || !is_numeric($this->parejaMin) || !is_numeric($this->parejaSum) || !is_numeric($this->hijos) || !is_numeric($this->regalos) || !is_numeric($this->deudas) || !is_numeric($this->pension)) {
                throw new Exception("Uno o más valores ingresados no son numéricos. Por favor, ingrese solo números.");
            }
            
            $total = 0;
            $reflector = new ReflectionClass($this);
            $propiedades = $reflector->getProperties();
            foreach ($propiedades as $propiedad) {
                $nombrePropiedad = $propiedad->getName();
                if ($nombrePropiedad === 'regalos' || $nombrePropiedad === 'deudas' || $nombrePropiedad === 'parejaMin'|| $nombrePropiedad === 'hijos' ) {
                    $total -= $this->{$nombrePropiedad};
                } else {
                    $total += $this->{$nombrePropiedad};
                }
            }
            
            return number_format((float)$total, 2, '.', '');
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
    
}

try {
    echo "Por favor, introduce tu edad: ";
    $edad = trim(fgets(STDIN));
    
    if (!is_numeric($edad)) {
        throw new Exception("La edad ingresada no es un número. Por favor, ingrese solo números.");
    }
    
    $dinero = new Dinero($edad);
    echo "\nA la edad de " . $edad . ", el total de dinero que tienes es: " . $dinero->calcularTotal();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
