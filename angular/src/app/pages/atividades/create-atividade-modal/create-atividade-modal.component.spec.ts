import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateAtividadeModalComponent } from './create-atividade-modal.component';

describe('CreateAtividadeModalComponent', () => {
  let component: CreateAtividadeModalComponent;
  let fixture: ComponentFixture<CreateAtividadeModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateAtividadeModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateAtividadeModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
