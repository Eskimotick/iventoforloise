import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AtividadeModalComponent } from './atividade-modal.component';

describe('AtividadeModalComponent', () => {
  let component: AtividadeModalComponent;
  let fixture: ComponentFixture<AtividadeModalComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AtividadeModalComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AtividadeModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
