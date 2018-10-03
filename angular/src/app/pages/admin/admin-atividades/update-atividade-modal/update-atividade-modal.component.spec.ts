import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UpdateAtividadeModalComponent } from './update-atividade-modal.component';

describe('UpdateAtividadeModalComponent', () => {
  let component: UpdateAtividadeModalComponent;
  let fixture: ComponentFixture<UpdateAtividadeModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UpdateAtividadeModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UpdateAtividadeModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
