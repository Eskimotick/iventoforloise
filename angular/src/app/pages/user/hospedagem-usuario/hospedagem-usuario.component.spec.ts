import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HospedagemUsuarioComponent } from './hospedagem-usuario.component';

describe('HospedagemUsuarioComponent', () => {
  let component: HospedagemUsuarioComponent;
  let fixture: ComponentFixture<HospedagemUsuarioComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HospedagemUsuarioComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HospedagemUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
