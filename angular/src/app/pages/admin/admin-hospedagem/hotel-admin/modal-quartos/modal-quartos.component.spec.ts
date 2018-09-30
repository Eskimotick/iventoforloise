import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalQuartosComponent } from './modal-quartos.component';

describe('ModalQuartosComponent', () => {
  let component: ModalQuartosComponent;
  let fixture: ComponentFixture<ModalQuartosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalQuartosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalQuartosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
