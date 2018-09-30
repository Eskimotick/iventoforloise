import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';

import { AtividadesService } from '../../../services/atividades/atividades.service';

@Component({
  selector: 'app-create-atividade-modal',
  templateUrl: './create-atividade-modal.component.html',
  styleUrls: ['./create-atividade-modal.component.css']
})
export class CreateAtividadeModalComponent implements OnInit, OnChanges {

	@Input('createClick') createClick: number;
	@Input('evento') evento: string;
  @Input('pacotes') pacotes: any[];
	createAtividadeModal = new EventEmitter<string|MaterializeAction>();
  @Output() createAtividadeEmitter = new EventEmitter<any>();

  file: File = new File([""], "filename");
  imagem: string;

  checkboxMarked: boolean[] = [];

  constructor(private atividadesService: AtividadesService) {
    this.imagem = '';
  }

  ngOnInit() {
  }

  ngOnChanges() {
		console.log(this.createClick);
		if(this.createClick)
			this.openModal();
	}

  openModal() {
  	this.createAtividadeModal.emit({action: 'modal', params: ['open']});
  }

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
    }
    myReader.readAsDataURL(this.file);
  }

  onSubmit(atividadeForm) {
    let atividade = atividadeForm.value;
    atividade.status = 'Aberto';
    atividade.pacotes = []; 
    let pacoteString = { array: [], string: '' };
    for(let i = 0; i < this.checkboxMarked.length; i++) {
      if(this.checkboxMarked[i]) {
        atividade.pacotes.push(i);
        pacoteString.array.push(this.pacotes[i].id);
      }
    }
    pacoteString.string = pacoteString.array.join(',');
    atividade.image = this.imagem;
    this.atividadesService.store(atividade, pacoteString.string).subscribe(
      (res) => {
        console.log(res);
        this.createAtividadeEmitter.emit(atividade);
        this.createAtividadeModal.emit({action: 'modal', params: ['close']});
    });
  }

}
