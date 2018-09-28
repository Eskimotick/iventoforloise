import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-hotel-admin',
  templateUrl: './hotel-admin.component.html',
  styleUrls: ['./hotel-admin.component.css']
})
export class HotelAdminComponent implements OnInit {

  @Input('hoteis') hoteis: any;
  @Input('hotelFoto') hotelFoto: string;


  pacotes: string[] = [
    'Pacote Standard', 'Pacote Master', 'Pacote Simples'
  ]

  quartos: any[] = [{
    nomeQuarto: 'Suite Standard',
    numeroQuarto: 42,
    numeroVagas: 2,
    observacoes: 'Lorem Ipsum Dolor Sit Amet ...', 
    pacotes: ''
    
  }]

  imagem: any = '';

  file: File = new File([""], "filename");

  onFileSelection(imagem) {
    let fileList: FileList = imagem.target.files;
      if(fileList.length > 0) {
        this.file = fileList[0];
        this.readThis();
      }

  }

  readThis(){
    let myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.imagem = myReader.result;
      console.log(this.imagem);
    }
    myReader.readAsDataURL(this.file);
  }
  
  constructor() { }

  ngOnInit() {
  }

}
