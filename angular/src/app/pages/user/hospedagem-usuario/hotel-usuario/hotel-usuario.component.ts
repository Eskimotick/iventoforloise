import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-hotel-usuario',
  templateUrl: './hotel-usuario.component.html',
  styleUrls: ['./hotel-usuario.component.css']
})
export class HotelUsuarioComponent implements OnInit {


  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  quartos: any[] = [{
    nomeQuarto: 'Suite Standard',
    numeroQuarto: 42,
    numeroVagas: 2,
    obsQuartos: 'Lorem Ipsum Dolor Sit Amet ...', 
    pacotes: ''
    
  }]

  constructor() { }

  ngOnInit() {
  }

}
