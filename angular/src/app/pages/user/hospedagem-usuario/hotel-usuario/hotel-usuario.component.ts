import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hotel-usuario',
  templateUrl: './hotel-usuario.component.html',
  styleUrls: ['./hotel-usuario.component.css']
})
export class HotelUsuarioComponent implements OnInit {


  usuario: any[] = [{
    nomeUsuario: 'Usuário',
    

  }]

  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  quartos: any[] = [{
    tipoQuarto: 'Suite Standard',
    numeroQuarto: 42,
    numeroVagasPorQuarto: 2,
    numeroQuartosRestantes: 3,
    obsQuartos: 'Lorem Ipsum Dolor Sit Amet ...', 
    pacotes: ''
    
  }]

  constructor() { }

  ngOnInit() {
  }

}
