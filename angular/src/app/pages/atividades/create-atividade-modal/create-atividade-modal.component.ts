import { Component, OnInit, OnChanges, Input, Output, EventEmitter } from '@angular/core';
import { MaterializeAction } from 'angular2-materialize';

@Component({
  selector: 'app-create-atividade-modal',
  templateUrl: './create-atividade-modal.component.html',
  styleUrls: ['./create-atividade-modal.component.css']
})
export class CreateAtividadeModalComponent implements OnInit, OnChanges {

	@Input('createClick') createClick: number;
	@Input('evento') evento: string;
  @Input('pacotes') pacotes: string[];
	createAtividadeModal = new EventEmitter<string|MaterializeAction>();
  @Output() createAtividadeEmitter = new EventEmitter<any>();

  file: File = new File([""], "filename");
  imagem: string;

  checkboxMarked: boolean[] = [];

  constructor() {
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
    atividade.status = true;
    console.log(this.checkboxMarked);
    this.createAtividadeEmitter.emit(atividade);
    this.createAtividadeModal.emit({action: 'modal', params: ['close']});
  }

}
